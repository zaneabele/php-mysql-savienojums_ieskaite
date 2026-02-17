<?php
// funkcijas.php - datubāzes savienojums un funkcijas

// Datubāzes savienojuma parametri
$host = 'localhost';
$dbname = 'ieskaite_db';    // TAVS DATUBĀZES NOSAUKUMS!
$username = 'root';
$password = 'Zanite22';              // Parole, ja tāda ir (tukša, ja nav)

// Savienojuma izveide
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kļūda savienojumā: " . $e->getMessage());
}

/**
 * menu() funkcija - izveido nenumurētu sarakstu ar personām
 * @return string HTML kods ar personu sarakstu
 */
function menu() {
    global $pdo;
    
    try {
        // Nolasām visus ierakstus no personas tabulas
        $sql = "SELECT id, vards FROM personas ORDER BY vards";
        $stmt = $pdo->query($sql);
        $personas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Sākam veidot HTML
        $html = '<ul>';
        
        // Katrai personai izveidojam saiti
        foreach ($personas as $persona) {
            $html .= '<li><a href="?id=' . $persona['id'] . '">' . 
                     htmlspecialchars($persona['vards']) . 
                     '</a></li>';
        }
        
        $html .= '</ul>';
        
        // Ja nav neviena ieraksta, parādām paziņojumu
        if (empty($personas)) {
            $html = '<p>Nav pievienotu personu.</p>';
        }
        
        return $html;
        
    } catch(PDOException $e) {
        return '<p style="color: red;">Kļūda: ' . $e->getMessage() . '</p>';
    }
}

/**
 * content() funkcija - atspoguļo personas informāciju
 * @return string HTML kods ar personas aprakstu
 */
function content() {
    global $pdo;
    
    // Pārbaudām, vai ir norādīts ID
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
        
        try {
            // Nolasām konkrētās personas datus
            $sql = "SELECT vards, apraksts FROM personas WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $id]);
            $persona = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Ja persona atrasta, parādām tās datus
            if ($persona) {
                $html = '<h3>' . htmlspecialchars($persona['vards']) . '</h3>';
                $html .= '<p>' . nl2br(htmlspecialchars($persona['apraksts'])) . '</p>';
                return $html;
            } else {
                return '<p>Persona nav atrasta.</p>';
            }
            
        } catch(PDOException $e) {
            return '<p style="color: red;">Kļūda: ' . $e->getMessage() . '</p>';
        }
    } else {
        // Ja ID nav norādīts, parādām pirmo personu
        try {
            $sql = "SELECT vards, apraksts FROM personas ORDER BY id LIMIT 1";
            $stmt = $pdo->query($sql);
            $persona = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($persona) {
                $html = '<h3>' . htmlspecialchars($persona['vards']) . '</h3>';
                $html .= '<p>' . nl2br(htmlspecialchars($persona['apraksts'])) . '</p>';
                return $html;
            } else {
                return '<p>Nav pievienotu personu.</p>';
            }
            
        } catch(PDOException $e) {
            return '<p style="color: red;">Kļūda: ' . $e->getMessage() . '</p>';
        }
    }
}
?>