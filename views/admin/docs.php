<style>
.docs-wrap { max-width: 800px; }
.docs-wrap h2 {
    font-family: var(--font-display);
    font-size: 1.5rem;
    color: var(--color-navy);
    letter-spacing: -0.02em;
    margin: 2.5rem 0 0.75rem;
    padding-top: 2.5rem;
    border-top: 1px solid var(--color-border);
}
.docs-wrap h2:first-of-type { margin-top: 0; padding-top: 0; border-top: none; }
.docs-wrap h3 {
    font-family: var(--font-body);
    font-size: 1rem;
    font-weight: 700;
    color: var(--color-text);
    margin: 1.5rem 0 0.5rem;
}
.docs-wrap p {
    font-family: var(--font-body);
    font-size: 0.9375rem;
    color: var(--color-muted);
    line-height: 1.75;
    margin-bottom: 0.75rem;
}
.docs-wrap ul {
    list-style: disc;
    padding-left: 1.25rem;
    margin-bottom: 0.75rem;
}
.docs-wrap ul li {
    font-family: var(--font-body);
    font-size: 0.9375rem;
    color: var(--color-muted);
    line-height: 1.75;
    margin-bottom: 0.25rem;
}
.docs-wrap ul li strong {
    font-weight: 700;
    color: var(--color-text);
}
.docs-table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0 1.5rem;
    background: var(--color-white);
    border: 1px solid var(--color-border);
}
.docs-table th {
    font-family: var(--font-ui);
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--color-subtle);
    background: var(--color-bg);
    padding: 0.625rem 1rem;
    text-align: left;
    border-bottom: 1px solid var(--color-border);
}
.docs-table td {
    font-family: var(--font-body);
    font-size: 0.875rem;
    color: var(--color-muted);
    padding: 0.625rem 1rem;
    border-bottom: 1px solid var(--color-border-soft);
    vertical-align: top;
}
.docs-table tr:last-child td { border-bottom: none; }
.docs-table td:first-child {
    font-family: var(--font-ui);
    font-weight: 600;
    color: var(--color-text);
    white-space: nowrap;
}
.docs-note {
    background: #EEF4FB;
    border-left: 3px solid var(--color-cta);
    padding: 0.875rem 1.125rem;
    margin: 1rem 0;
    font-family: var(--font-body);
    font-size: 0.875rem;
    color: #1a3a5c;
    line-height: 1.65;
}
.docs-warn {
    background: #FEF3C7;
    border-left: 3px solid #D97706;
    padding: 0.875rem 1.125rem;
    margin: 1rem 0;
    font-family: var(--font-body);
    font-size: 0.875rem;
    color: #78350F;
    line-height: 1.65;
}
.docs-section-intro {
    font-family: var(--font-body);
    font-size: 1rem;
    color: var(--color-muted);
    line-height: 1.75;
    margin-bottom: 1.25rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid var(--color-border-soft);
}
.docs-toc {
    background: var(--color-white);
    border: 1px solid var(--color-border);
    padding: 1.5rem;
    margin-bottom: 2.5rem;
}
.docs-toc-title {
    font-family: var(--font-ui);
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--color-subtle);
    margin-bottom: 1rem;
}
.docs-toc ol {
    list-style: decimal;
    padding-left: 1.25rem;
}
.docs-toc ol li {
    font-family: var(--font-ui);
    font-size: 0.875rem;
    line-height: 1.8;
}
.docs-toc ol li a {
    color: var(--color-cta);
    text-decoration: underline;
    text-underline-offset: 3px;
}
.docs-toc ol li a:hover { color: var(--color-cta-dark); }
</style>

<div class="docs-wrap">

    <!-- Cuprins -->
    <div class="docs-toc">
        <div class="docs-toc-title">Cuprins</div>
        <ol>
            <li><a href="#dashboard">Dashboard — vedere de ansamblu</a></li>
            <li><a href="#categorii">Categorii</a></li>
            <li><a href="#produse">Produse</a></li>
            <li><a href="#blog">Blog</a></li>
            <li><a href="#testimoniale">Testimoniale</a></li>
            <li><a href="#contacte">Contacte</a></li>
            <li><a href="#comenzi">Comenzi</a></li>
            <li><a href="#magazin">Magazin online &amp; coș</a></li>
            <li><a href="#setari">Setări — Stripe &amp; plăți</a></li>
            <li><a href="#securitate">Securitate si acces</a></li>
            <li><a href="#imagini">Reguli pentru imagini</a></li>
        </ol>
    </div>

    <!-- 1. Dashboard -->
    <h2 id="dashboard">1. Dashboard</h2>
    <p class="docs-section-intro">
        Pagina principală a adminului. Oferă o vedere de ansamblu asupra activității site-ului,
        fără a fi nevoie să intri în fiecare secțiune separat.
    </p>

    <h3>Cardurile de analitice</h3>
    <table class="docs-table">
        <thead><tr><th>Card</th><th>Ce arata</th><th>De unde vine datele</th></tr></thead>
        <tbody>
            <tr>
                <td>Total Produse</td>
                <td>Numărul total de produse din catalog, indiferent de categorie.</td>
                <td>Tabelul <code>products</code></td>
            </tr>
            <tr>
                <td>Vizitatori unici</td>
                <td>Numărul de sesiuni distincte care au accesat site-ul public. Un vizitator care revine în aceeași sesiune de browser este numărat o singură dată.</td>
                <td>Tabelul <code>page_views</code>, coloana <code>session_id</code></td>
            </tr>
            <tr>
                <td>Total Comenzi</td>
                <td>Numărul de comenzi active (exclusiv cele cu statusul "Anulat").</td>
                <td>Tabelul <code>orders</code></td>
            </tr>
            <tr>
                <td>Rata de conversie</td>
                <td>Procentul vizitatorilor care au luat o acțiune: au trimis un mesaj de contact sau au plasat o comandă. Formula: (contacte + comenzi) ÷ vizitatori unici × 100.</td>
                <td><code>contact_submissions</code> + <code>orders</code> + <code>page_views</code></td>
            </tr>
            <tr>
                <td>Total Venit</td>
                <td>Suma câmpului "Total" din comenzile cu statusul "Finalizat". Comenzile în așteptare sau confirmate nu sunt incluse.</td>
                <td>Tabelul <code>orders</code>, filtru <code>status = 'completed'</code></td>
            </tr>
            <tr>
                <td>Mesaje necitite</td>
                <td>Câte mesaje din formularul de contact nu au fost marcate ca citite. Același număr apare ca badge în meniu.</td>
                <td>Tabelul <code>contact_submissions</code>, coloana <code>is_read</code></td>
            </tr>
        </tbody>
    </table>

    <h3>Graficul vizitatorilor</h3>
    <p>
        Bara de jos afișează vizitatorii unici pe fiecare zi din ultimele 30 de zile.
        Bara cea mai înaltă reprezintă ziua cu cel mai mare trafic — toate celelalte sunt scalate față de aceasta.
        Treci cu mouse-ul peste o bară pentru a vedea data exactă și numărul de vizitatori.
    </p>
    <div class="docs-note">
        Tracking-ul este intern, bazat pe sesiuni PHP. Nu folosește cookies de third-party și nu necesită
        banner GDPR pentru această funcție. Adminul autentificat nu este niciodată contorizat ca vizitator.
    </div>

    <!-- 2. Categorii -->
    <h2 id="categorii">2. Categorii</h2>
    <p class="docs-section-intro">
        Categoriile grupează produsele din catalog. Un produs poate aparține unei singure categorii.
        Categoriile sunt afișate pe site în dreptul fiecărui produs.
    </p>

    <h3>Câmpuri</h3>
    <table class="docs-table">
        <thead><tr><th>Câmp</th><th>Descriere</th><th>Obligatoriu</th></tr></thead>
        <tbody>
            <tr><td>Nume</td><td>Numele categoriei afișat pe site (ex: "Mochete Premium").</td><td>Da</td></tr>
            <tr><td>Slug</td><td>Versiunea URL-friendly a numelui, generată automat dacă lași câmpul gol (ex: "mochete-premium"). Trebuie să fie unic.</td><td>Da (auto)</td></tr>
            <tr><td>Ordine afisare</td><td>Număr întreg care controlează ordinea în liste. Valoarea mai mică apare prima.</td><td>Nu (implicit 0)</td></tr>
        </tbody>
    </table>

    <h3>Cum sterg o categorie?</h3>
    <p>
        La ștergerea unei categorii, produsele asociate nu sunt șterse — câmpul lor <code>category_id</code>
        devine NULL. Produsele rămân vizibile în catalog, dar fără categorie atribuită.
        Atribuie o altă categorie produselor înainte de ștergere, dacă vrei să le păstrezi clasificate.
    </p>

    <!-- 3. Produse -->
    <h2 id="produse">3. Produse</h2>
    <p class="docs-section-intro">
        Catalogul de produse afișat pe pagina principală și în mega-meniu. Poți adăuga produse noi,
        edita detaliile existente și controla ordinea în care apar pe site.
    </p>

    <h3>Câmpuri de bază</h3>
    <table class="docs-table">
        <thead><tr><th>Câmp</th><th>Descriere</th><th>Obligatoriu</th></tr></thead>
        <tbody>
            <tr><td>Nume</td><td>Numele produsului afișat pe card și în titluri.</td><td>Da</td></tr>
            <tr><td>Slug</td><td>Identificator URL unic, generat automat din nume. Pagina produsului va fi accesibilă la <code>/produs/{slug}</code>.</td><td>Da (auto)</td></tr>
            <tr><td>Categorie</td><td>Selectează din categoriile existente. Dacă nicio categorie nu se potrivește, creează una mai întâi din secțiunea Categorii.</td><td>Nu</td></tr>
            <tr><td>Pret / eticheta</td><td>Text liber afișat pe card când nu există un preț/m² setat (ex: "Preț la cerere"). Dacă setezi câmpul <em>Preț / m²</em>, acesta are prioritate.</td><td>Nu</td></tr>
            <tr><td>Titlu sectiune</td><td>Heading afișat pe pagina individuală a produsului.</td><td>Nu</td></tr>
            <tr><td>Descriere</td><td>Text descriptiv al produsului, afișat pe pagina produsului.</td><td>Nu</td></tr>
            <tr><td>Badge</td><td>Eticheta scurtă afișată peste imaginea produsului (ex: "Nou", "Recomandat", "Stoc limitat").</td><td>Nu</td></tr>
            <tr><td>Ordine</td><td>Controlează ordinea în grilă. Valoarea mai mică apare prima.</td><td>Nu (implicit 0)</td></tr>
            <tr><td>Produs featured</td><td>Bifat — produsul este exclus din grila principală de 4 produse de pe homepage și rezervat pentru o secțiune "featured" separată.</td><td>Nu</td></tr>
        </tbody>
    </table>

    <h3>Câmpuri pentru magazin online</h3>
    <p>Aceste câmpuri activează vânzarea online a produsului. Fără <strong>Preț / m²</strong>, produsul nu poate fi adăugat în coș — va afișa în schimb un buton „Solicită ofertă".</p>
    <table class="docs-table">
        <thead><tr><th>Câmp</th><th>Descriere</th><th>Obligatoriu</th></tr></thead>
        <tbody>
            <tr><td>Grosime</td><td>Text liber (ex: "6mm", "10mm"). Apare în fișa produsului și poate fi folosit ca filtru pe pagina categoriei.</td><td>Nu</td></tr>
            <tr><td>Culoare</td><td>Culoarea sau nuanța produsului (ex: "Gri antracit", "Bej"). Folosit ca filtru.</td><td>Nu</td></tr>
            <tr><td>Greutate / m²</td><td>Greutatea în kg/m². Informație tehnică afișată în fișa produsului.</td><td>Nu</td></tr>
            <tr><td>Preț / m² (RON)</td><td>Prețul de vânzare în lei per metru pătrat. <strong>Acesta este câmpul critic</strong> — fără el produsul nu are buton de coș.</td><td>Nu*</td></tr>
        </tbody>
    </table>

    <h3>Imagini</h3>
    <table class="docs-table">
        <thead><tr><th>Câmp</th><th>Descriere</th></tr></thead>
        <tbody>
            <tr><td>Imagine principală</td><td>Imaginea afișată pe card în grilă și ca primă imagine în galerie. Înlocuiește imaginea veche dacă încarci una nouă.</td></tr>
            <tr><td>Galerie imagini</td><td>Imagini suplimentare afișate ca miniaturi pe pagina produsului. Clientul poate naviga printre ele. Poți încărca mai multe odată. Fiecare imagine din galerie poate fi ștearsă individual din formularul de editare.</td></tr>
        </tbody>
    </table>

    <div class="docs-warn">
        La stergerea unui produs, imaginea principală și toate imaginile din galerie sunt sterse automat de pe server. Aceasta actiune este ireversibila.
    </div>

    <!-- 4. Blog -->
    <h2 id="blog">4. Blog</h2>
    <p class="docs-section-intro">
        Secțiunea de articole. Articolele pot fi salvate ca draft și publicate ulterior.
        Conținutul acceptă HTML direct în câmpul "Conținut".
    </p>

    <h3>Câmpuri</h3>
    <table class="docs-table">
        <thead><tr><th>Câmp</th><th>Descriere</th><th>Obligatoriu</th></tr></thead>
        <tbody>
            <tr><td>Titlu</td><td>Titlul articolului.</td><td>Da</td></tr>
            <tr><td>Slug</td><td>Identificator URL unic, generat automat. Odată publicat, evită modificarea slug-ului dacă articolul a fost deja distribuit — link-urile externe vor fi rupte.</td><td>Da (auto)</td></tr>
            <tr><td>Rezumat</td><td>Text scurt folosit în listinguri și preview-uri (max recomandat: 160 caractere).</td><td>Nu</td></tr>
            <tr><td>Continut</td><td>Corpul articolului în format HTML. Poți folosi tag-uri <code>&lt;p&gt;</code>, <code>&lt;h2&gt;</code>, <code>&lt;ul&gt;</code>, <code>&lt;strong&gt;</code>, <code>&lt;a&gt;</code> etc.</td><td>Da</td></tr>
            <tr><td>Imagine cover</td><td>Imaginea principală a articolului.</td><td>Nu</td></tr>
            <tr><td>Publicat</td><td>Bifat — articolul este vizibil public. Debifat — articolul rămâne draft, nevizibil pe site.</td><td>Nu</td></tr>
            <tr><td>Data publicare</td><td>Completată automat cu data curentă la prima publicare. Poți seta manual o dată în format <code>YYYY-MM-DD HH:MM:SS</code>.</td><td>Nu (auto)</td></tr>
        </tbody>
    </table>

    <h3>Flux de lucru recomandat</h3>
    <ul>
        <li>Creează articolul cu bifa "Publicat" debifată — se salvează ca <strong>draft</strong>.</li>
        <li>Editează și finalizează conținutul.</li>
        <li>Când este gata, editează articolul, bifează "Publicat" și salvează — data publicării se setează automat.</li>
        <li>Dacă re-editezi un articol publicat, data publicării originală rămâne nemodificată.</li>
    </ul>

    <!-- 5. Testimoniale -->
    <h2 id="testimoniale">5. Testimoniale</h2>
    <p class="docs-section-intro">
        Recenziile clienților afișate în secțiunea de testimoniale de pe pagina principală.
    </p>

    <h3>Câmpuri</h3>
    <table class="docs-table">
        <thead><tr><th>Câmp</th><th>Descriere</th><th>Obligatoriu</th></tr></thead>
        <tbody>
            <tr><td>Nume client</td><td>Numele afișat sub recenzie.</td><td>Da</td></tr>
            <tr><td>Locatie</td><td>Orașul sau județul clientului (ex: "Timișoara", "Cluj-Napoca").</td><td>Nu</td></tr>
            <tr><td>Recenzie</td><td>Textul complet al recenziei.</td><td>Da</td></tr>
            <tr><td>Rating</td><td>Număr de stele de la 1 la 5. Pe site se afișează ca stele pline.</td><td>Da (implicit 5)</td></tr>
            <tr><td>Ordine</td><td>Controlează ordinea în care apar testimonialele. Valoarea mai mică apare prima.</td><td>Nu (implicit 0)</td></tr>
        </tbody>
    </table>

    <!-- 6. Contacte -->
    <h2 id="contacte">6. Contacte</h2>
    <p class="docs-section-intro">
        Mesajele trimise prin formularul de contact de pe site. Această secțiune este <strong>doar pentru citit</strong> —
        nu poți adăuga sau edita mesaje, doar să le marchezi ca citite.
    </p>

    <h3>Cum functioneaza</h3>
    <ul>
        <li>Mesajele <strong>necitite</strong> apar cu fundal ușor evidențiat și cu eticheta "Necitit".</li>
        <li>Numărul de mesaje necitite apare ca badge în meniul lateral și în cardul "Inbox" de pe Dashboard.</li>
        <li>Apasă <strong>"Marchează citit"</strong> pe un mesaj pentru a-l marca ca procesat. Acțiunea nu poate fi anulată din interfață.</li>
        <li>Dacă dai click pe adresa de email a unui client, se deschide clientul de email cu adresa pre-completată.</li>
    </ul>

    <div class="docs-note">
        Mesajele nu sunt sterse automat. Dacă baza de date devine prea mare in timp, un administrator tehnic
        poate rula <code>DELETE FROM contact_submissions WHERE created_at &lt; DATE_SUB(NOW(), INTERVAL 1 YEAR)</code>
        pentru a curăța mesajele vechi.
    </div>

    <!-- 7. Comenzi -->
    <h2 id="comenzi">7. Comenzi</h2>
    <p class="docs-section-intro">
        Registrul tuturor comenzilor — atât cele plasate online prin magazin (plătite cu cardul via Stripe),
        cât și cele adăugate manual (preluate telefonic sau offline).
        Totalul vânzărilor din Dashboard reflectă doar comenzile cu statusul "Finalizat".
    </p>

    <h3>Comenzi online (Stripe)</h3>
    <p>
        Când un client finalizează o comandă prin magazin și plata este confirmată de Stripe,
        comanda apare automat în această secțiune cu statusul <strong>Confirmat</strong> și cu
        produsele detaliate (suprafață în m², preț/m², total pe linie).
        Câmpul <em>ID plată Stripe</em> (ex: <code>pi_3Abc...xyz</code>) îți permite să identifici
        tranzacția în <a href="https://dashboard.stripe.com/payments" target="_blank" rel="noopener">Stripe Dashboard</a>.
    </p>

    <h3>Comenzi manuale</h3>
    <p>Poți adăuga comenzi manual (telefon, email, față în față) folosind butonul „Comandă nouă".</p>
    <table class="docs-table">
        <thead><tr><th>Câmp</th><th>Descriere</th><th>Obligatoriu</th></tr></thead>
        <tbody>
            <tr><td>Nume client</td><td>Numele complet al clientului.</td><td>Da</td></tr>
            <tr><td>Email</td><td>Adresa de email a clientului.</td><td>Nu</td></tr>
            <tr><td>Telefon</td><td>Numărul de telefon al clientului.</td><td>Nu</td></tr>
            <tr><td>Total (RON)</td><td>Valoarea comenzii în lei. Folosește punct sau virgulă ca separator zecimal.</td><td>Da (implicit 0)</td></tr>
            <tr><td>Status</td><td>Vezi tabelul de statusuri de mai jos.</td><td>Da (implicit: În așteptare)</td></tr>
            <tr><td>Note</td><td>Detalii interne: produse comandate, adresa de livrare, observații speciale.</td><td>Nu</td></tr>
        </tbody>
    </table>

    <h3>Statusuri comenzi</h3>
    <table class="docs-table">
        <thead><tr><th>Status</th><th>Ce inseamna</th><th>Inclus in venit?</th></tr></thead>
        <tbody>
            <tr><td>In asteptare</td><td>Comanda a fost înregistrată dar nu a fost confirmată. Statusul implicit pentru comenzile manuale noi.</td><td>Nu</td></tr>
            <tr><td>Confirmat</td><td>Plata a fost încasată (automat pentru comenzile Stripe) sau clientul a confirmat offline. Lucrarea urmează să fie executată.</td><td>Nu</td></tr>
            <tr><td>Finalizat</td><td>Lucrarea a fost executată și plata a fost încasată integral. Apare în totalul veniturilor din Dashboard.</td><td>Da</td></tr>
            <tr><td>Anulat</td><td>Comanda a fost anulată. Nu mai apare în contorul de comenzi active.</td><td>Nu</td></tr>
        </tbody>
    </table>

    <div class="docs-note">
        Fluxul recomandat pentru comenzi manuale: <strong>In asteptare</strong> → discuție cu clientul → <strong>Confirmat</strong>
        → execuție lucrare → <strong>Finalizat</strong>. Comenzile online plasate prin Stripe intră direct în starea <strong>Confirmat</strong>.
    </div>

    <!-- 8. Magazin online -->
    <h2 id="magazin">8. Magazin online &amp; coș</h2>
    <p class="docs-section-intro">
        Sistemul de magazin permite clienților să navigheze produsele, să le adauge în coș
        și să finalizeze comanda cu plata online prin card. Nu necesită cont de client.
    </p>

    <h3>Paginile publice ale magazinului</h3>
    <table class="docs-table">
        <thead><tr><th>URL</th><th>Descriere</th></tr></thead>
        <tbody>
            <tr><td><code>/magazin</code></td><td>Grila tuturor produselor cu filtre pe categorii. Clienții pot naviga pe categorii sau vedea tot catalogul.</td></tr>
            <tr><td><code>/categorie/{slug}</code></td><td>Produsele dintr-o categorie specifică, cu filtre în sidebar (grosime, culoare, interval preț).</td></tr>
            <tr><td><code>/produs/{slug}</code></td><td>Pagina individuală a produsului: galerie imagini, descriere, specificații tehnice, formular de adăugare în coș cu selector de suprafață (m²).</td></tr>
            <tr><td><code>/cos</code></td><td>Coșul de cumpărături. Clientul poate modifica suprafețele (m²) sau șterge produse.</td></tr>
            <tr><td><code>/checkout</code></td><td>Formularul de finalizare: date de contact + livrare, plată cu cardul prin Stripe.</td></tr>
            <tr><td><code>/confirmare/{id}</code></td><td>Pagina de confirmare afișată după o plată reușită, cu detaliile comenzii.</td></tr>
        </tbody>
    </table>

    <h3>Cum funcționează coșul</h3>
    <ul>
        <li>Coșul este stocat în sesiunea PHP a browserului — nu necesită cont de utilizator.</li>
        <li>Produsul se adaugă specificând o <strong>suprafață în m²</strong> (ex: 15,5 m²). Prețul total = suprafață × preț/m².</li>
        <li>Dacă același produs este adăugat din nou, suprafața introdusă o <strong>înlocuiește</strong> pe cea anterioară (nu se cumulează).</li>
        <li>Coșul se golește automat după finalizarea cu succes a plății.</li>
        <li>Un produs fără câmpul <em>Preț / m²</em> completat nu poate fi adăugat în coș — va afișa „Solicită ofertă".</li>
    </ul>

    <h3>Fluxul de plată Stripe</h3>
    <ul>
        <li>La accesarea paginii <code>/checkout</code>, sistemul creează un <em>PaymentIntent</em> pe serverul Stripe.</li>
        <li>Clientul completează datele cardului direct în formularul Stripe (datele cardului nu trec prin serverul tău).</li>
        <li>Stripe confirmă plata în browser; abia după confirmare comanda este înregistrată în baza de date.</li>
        <li>Clientul este redirecționat la <code>/confirmare/{id}</code> cu rezumatul comenzii.</li>
    </ul>

    <div class="docs-note">
        Plata nu este procesată dacă clientul închide browserul după ce a introdus datele cardului dar înainte de confirmare.
        Stripe poate trimite și un eveniment webhook <code>payment_intent.succeeded</code> la adresa
        <code>/stripe/webhook</code> ca mecanism de rezervă, dar acesta necesită configurarea <em>Webhook Secret</em>
        în secțiunea Setări.
    </div>

    <h3>Card de test Stripe</h3>
    <p>
        În modul test (chei <code>pk_test_</code> / <code>sk_test_</code>), folosește cardul
        <strong>4242 4242 4242 4242</strong>, orice dată de expirare viitoare și orice 3 cifre ca CVC.
        Plata va fi confirmată fără a debita bani reali.
    </p>

    <!-- 9. Setări -->
    <h2 id="setari">9. Setări — Stripe &amp; plăți</h2>
    <p class="docs-section-intro">
        Pagina de Setări (<a href="<?= BASE_URL ?>admin/settings">Admin → Setări</a>) permite configurarea
        integrării Stripe direct din interfață, fără a edita fișiere de pe server.
        Cheile sunt stocate în baza de date și nu sunt niciodată expuse în codul sursă.
    </p>

    <h3>Unde găsești cheile Stripe</h3>
    <ol style="padding-left:1.25rem;font-family:var(--font-body);font-size:.9375rem;color:var(--color-muted);line-height:1.75;">
        <li>Autentifică-te pe <a href="https://dashboard.stripe.com" target="_blank" rel="noopener">dashboard.stripe.com</a></li>
        <li>Mergi la <strong>Developers → API keys</strong></li>
        <li>Copiază <em>Publishable key</em> și <em>Secret key</em></li>
        <li>Pentru webhook: <strong>Developers → Webhooks → Add endpoint</strong>, URL: <code>https://domeniu.ro/stripe/webhook</code>, eveniment: <code>payment_intent.succeeded</code></li>
    </ol>

    <h3>Cele trei chei</h3>
    <table class="docs-table">
        <thead><tr><th>Cheie</th><th>Prefix</th><th>Unde este folosită</th><th>Este secretă?</th></tr></thead>
        <tbody>
            <tr>
                <td>Publishable Key</td>
                <td><code>pk_test_</code> / <code>pk_live_</code></td>
                <td>În browser, de Stripe.js pentru a iniția plata. Vizibilă în codul HTML al paginii de checkout.</td>
                <td>Nu — poate fi publică</td>
            </tr>
            <tr>
                <td>Secret Key</td>
                <td><code>sk_test_</code> / <code>sk_live_</code></td>
                <td>Doar pe server, pentru a crea PaymentIntent-uri. Nu ajunge niciodată în browser.</td>
                <td><strong>Da — păstrează-o secretă</strong></td>
            </tr>
            <tr>
                <td>Webhook Secret</td>
                <td><code>whsec_</code></td>
                <td>Verifică semnătura evenimentelor primite de la Stripe la <code>/stripe/webhook</code>. Opțional, dar recomandat în producție.</td>
                <td><strong>Da — păstrează-o secretă</strong></td>
            </tr>
        </tbody>
    </table>

    <h3>Modul test vs. modul live</h3>
    <p>
        Stripe oferă două seturi de chei: <strong>test</strong> (tranzacțiile nu sunt reale, banii nu sunt debitați)
        și <strong>live</strong> (tranzacții reale). Asigură-te că folosești:
    </p>
    <ul>
        <li><strong>Chei test</strong> (<code>pk_test_</code>, <code>sk_test_</code>) în timpul dezvoltării și testării.</li>
        <li><strong>Chei live</strong> (<code>pk_live_</code>, <code>sk_live_</code>) când site-ul este publicat și acceptă clienți reali.</li>
    </ul>
    <div class="docs-warn">
        Nu pune niciodată cheia <strong>Secret Key</strong> în cod JavaScript, în email-uri sau în alt loc public.
        Dacă o cheie secretă este compromisă, revoc-o imediat din Stripe Dashboard (Developers → API keys → Roll key)
        și înlocuiește-o în Setări.
    </div>

    <h3>Bannerul de status</h3>
    <p>
        Pagina de Setări afișează un banner verde dacă ambele chei (Publishable + Secret) sunt completate,
        sau galben dacă lipsește cel puțin una. Verifică bannerul după orice modificare.
    </p>

    <!-- 10. Securitate -->
    <h2 id="securitate">10. Securitate si acces</h2>

    <h3>Autentificarea</h3>
    <p>
        Panoul de admin este accesibil la adresa <code>/admin/login</code> și este protejat prin parolă.
        Sesiunea de autentificare durează cât timp browserul este deschis. La închiderea browserului sau
        la click pe "Deconectare", sesiunea expiră și accesul este revocat.
    </p>
    <p>
        Dacă accesezi orice pagină din <code>/admin/</code> fără să fii autentificat, ești redirecționat
        automat la pagina de login.
    </p>

    <h3>Schimbarea parolei</h3>
    <p>
        Parola nu se poate schimba din interfața admin. Un administrator tehnic trebuie să:
    </p>
    <ul>
        <li>Genereze un hash nou rulând în terminal: <code>php -r "echo password_hash('parola_noua', PASSWORD_BCRYPT, ['cost'=>12]);"</code></li>
        <li>Înlocuiască valoarea <code>ADMIN_PASS_HASH</code> din fișierul <code>config/admin.php</code>.</li>
    </ul>
    <div class="docs-warn">
        Parola implicita de instalare este <strong>stepupfloor2024</strong>. Schimb-o inainte ca site-ul
        sa fie publicat pe internet.
    </div>

    <h3>CSRF — protectia formularelor</h3>
    <p>
        Toate formularele care modifică date (creare, editare, ștergere) includ un token de securitate
        generat automat la autentificare. Acesta previne atacurile în care un site extern ar putea
        trimite acțiuni neautorizate în numele tău. Nu este nevoie să faci nimic special — funcționează în fundal.
    </p>

    <!-- 11. Imagini -->
    <h2 id="imagini">11. Reguli pentru imagini</h2>

    <table class="docs-table">
        <thead><tr><th>Regula</th><th>Detaliu</th></tr></thead>
        <tbody>
            <tr><td>Formate acceptate</td><td>JPEG, PNG, WebP</td></tr>
            <tr><td>Dimensiune maxima</td><td>3 MB per imagine</td></tr>
            <tr><td>Stocare produse</td><td><code>assets/images/products/</code> — atât imaginea principală cât și galeria</td></tr>
            <tr><td>Stocare blog</td><td><code>assets/images/blog/</code></td></tr>
            <tr><td>Denumire fisier</td><td>Generată automat (ex: <code>img_6849a3f2b1c4d.jpg</code>). Nu păstrează numele original al fișierului.</td></tr>
            <tr><td>Stergere automata</td><td>Când ștergi un produs, imaginea principală și toate imaginile din galerie sunt șterse automat. La ștergerea unui articol, imaginea cover este ștearsă.</td></tr>
            <tr><td>Inlocuire imagine principala</td><td>Dacă încarci o imagine nouă la editare, imaginea veche este ștearsă automat și înlocuită.</td></tr>
            <tr><td>Galerie produse</td><td>Imaginile din galerie se adaugă cumulativ — pot fi șterse individual din formularul de editare. Nu există limită de număr, dar recomandăm max. 8–10 per produs.</td></tr>
        </tbody>
    </table>

    <h3>Recomandari practice</h3>
    <ul>
        <li>Folosește <strong>WebP</strong> pentru fișiere mai mici și calitate mai bună — toate browserele moderne îl suportă.</li>
        <li>Optimizează imaginile înainte de upload (tools gratuite: <a href="https://squoosh.app" target="_blank" rel="noopener">squoosh.app</a>, <a href="https://tinypng.com" target="_blank" rel="noopener">tinypng.com</a>).</li>
        <li>Raportul de aspect recomandat pentru produse: <strong>5:4</strong> (ex: 1000×800 px).</li>
        <li>Imaginile sunt servite direct din folderul <code>assets/</code> — nu există redimensionare automată pe server.</li>
    </ul>

</div>
