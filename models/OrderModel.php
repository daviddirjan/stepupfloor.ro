<?php

class OrderModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function getAll(): array
    {
        return $this->db->query('SELECT * FROM orders ORDER BY created_at DESC')->fetchAll();
    }

    public function findById(int $id): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $d): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, customer_city,
             notes, stripe_payment_intent_id, total, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $d['customer_name'], $d['customer_email'], $d['customer_phone'],
            $d['customer_address'] ?? '', $d['customer_city'] ?? '',
            $d['notes'] ?? '', $d['stripe_payment_intent_id'] ?? '',
            (float)$d['total'], $d['status'],
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function createWithItems(array $order, array $items): int
    {
        $this->db->beginTransaction();
        try {
            $orderId = $this->create($order);
            $stmt = $this->db->prepare(
                'INSERT INTO order_items (order_id, product_id, product_name, product_slug, area_m2, price_per_m2, total_price)
                 VALUES (?, ?, ?, ?, ?, ?, ?)'
            );
            foreach ($items as $item) {
                $stmt->execute([
                    $orderId,
                    $item['product_id'] ?: null,
                    $item['product_name'],
                    $item['product_slug'] ?? '',
                    (float)$item['area_m2'],
                    (float)$item['price_per_m2'],
                    (float)$item['total_price'],
                ]);
            }
            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function findWithItems(int $id): array|false
    {
        $order = $this->findById($id);
        if (!$order) return false;
        $stmt = $this->db->prepare('SELECT * FROM order_items WHERE order_id = ? ORDER BY id ASC');
        $stmt->execute([$id]);
        $order['items'] = $stmt->fetchAll();
        return $order;
    }

    public function updatePaymentIntent(int $id, string $paymentIntentId): bool
    {
        $stmt = $this->db->prepare('UPDATE orders SET stripe_payment_intent_id = ? WHERE id = ?');
        return $stmt->execute([$paymentIntentId, $id]);
    }

    public function findByPaymentIntent(string $paymentIntentId): array|false
    {
        $stmt = $this->db->prepare('SELECT * FROM orders WHERE stripe_payment_intent_id = ?');
        $stmt->execute([$paymentIntentId]);
        return $stmt->fetch();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare('UPDATE orders SET status = ? WHERE id = ?');
        return $stmt->execute([$status, $id]);
    }

    public function update(int $id, array $d): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE orders SET customer_name=?, customer_email=?, customer_phone=?, notes=?, total=?, status=? WHERE id=?'
        );
        return $stmt->execute([
            $d['customer_name'], $d['customer_email'], $d['customer_phone'],
            $d['notes'], (float)$d['total'], $d['status'], $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM orders WHERE id = ?');
        return $stmt->execute([$id]);
    }

    // Analytics helpers
    public function countTotal(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM orders WHERE status != "cancelled"')->fetchColumn();
    }

    public function totalRevenue(): float
    {
        return (float) $this->db->query('SELECT COALESCE(SUM(total),0) FROM orders WHERE status = "completed"')->fetchColumn();
    }
}
