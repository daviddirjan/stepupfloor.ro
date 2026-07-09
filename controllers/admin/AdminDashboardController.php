<?php

class AdminDashboardController
{
    public function index(): void
    {
        $db = Database::connection();

        $totalVisitors  = (int) $db->query('SELECT COUNT(DISTINCT session_id) FROM page_views')->fetchColumn();
        $totalContacts  = (int) $db->query('SELECT COUNT(*) FROM contact_submissions')->fetchColumn();
        $totalOrders    = (int) $db->query('SELECT COUNT(*) FROM orders WHERE status != "cancelled"')->fetchColumn();
        $totalRevenue   = (float) $db->query('SELECT COALESCE(SUM(total),0) FROM orders WHERE status = "completed"')->fetchColumn();

        // Conversion: (contacts + orders) / unique visitors * 100
        $converted       = $totalContacts + $totalOrders;
        $conversionRate  = $totalVisitors > 0 ? round($converted / $totalVisitors * 100, 1) : 0;

        // Visitors over last 30 days for sparkline
        $visitorsChart = $db->query(
            'SELECT DATE(created_at) AS day, COUNT(DISTINCT session_id) AS cnt
             FROM page_views
             WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
             GROUP BY DATE(created_at)
             ORDER BY day ASC'
        )->fetchAll();

        $data = [
            'pageTitle'      => 'Dashboard',
            'countProducts'  => (int) $db->query('SELECT COUNT(*) FROM products')->fetchColumn(),
            'countCategories'=> (int) $db->query('SELECT COUNT(*) FROM categories')->fetchColumn(),
            'countUnread'    => (int) $db->query('SELECT COUNT(*) FROM contact_submissions WHERE is_read = 0')->fetchColumn(),
            'countContacts'  => $totalContacts,
            'totalVisitors'  => $totalVisitors,
            'totalOrders'    => $totalOrders,
            'totalRevenue'   => $totalRevenue,
            'conversionRate' => $conversionRate,
            'visitorsChart'  => $visitorsChart,
        ];

        $this->render('admin/dashboard', $data);
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        $content = BASE_PATH . '/views/' . $view . '.php';
        require BASE_PATH . '/views/layouts/admin.php';
    }
}
