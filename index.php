<?php
/**************************************************************
 * index.php - Unified Router (Session + MySQL + Achievements + Comments + Samples)
 **************************************************************/
session_start();
require_once __DIR__ . '/db.php'; // $pdo

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function current_session_user_id() {
    return isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
}
function current_session_username() {
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}
function require_login() {
    if (!current_session_user_id()) {
        http_response_code(403);
        echo json_encode(["status"=>"error","message"=>"Not logged in"]);
        exit;
    }
}

$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method      = $_SERVER['REQUEST_METHOD'];

/**************************************************************
 * Serve static pages (GET)
 **************************************************************/
if ($method==='GET') {
    if ($request_uri==='/') {
        readfile("index.html");
        exit;
    } elseif ($request_uri==='/list') {
        readfile("list.html");
        exit;
    } elseif ($request_uri==='/profile') {
        readfile("profile.html");
        exit;
    } elseif ($request_uri==='/about') {
        readfile("about.html");
        exit;
    } elseif ($request_uri==='/usage') {
        readfile("usage.html");
        exit;
    } elseif ($request_uri==='/media') {
        readfile("media.html");
        exit;
    } elseif ($request_uri==='/changelog') {
        readfile("changelog.html");
        exit;
    }
}

/**************************************************************
 * 1) AUTH: /auth/login, /auth/logout
 **************************************************************/
if ($method==='POST' && $request_uri==='/auth/login') {
    $body = json_decode(file_get_contents('php://input'), true);
    if (!$body || empty($body['username']) || empty($body['password'])) {
        http_response_code(400);
        echo json_encode(["status"=>"error","message"=>"Username/password required"]);
        exit;
    }
    $username = trim($body['username']);
    $password = $body['password'];
    $stmt = $pdo->prepare("SELECT id,password_hash FROM users WHERE username=?");
    $stmt->execute([$username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        // Auto-create user if doesn't exist
        $pw_hash = password_hash($password, PASSWORD_BCRYPT);
        $ins = $pdo->prepare("INSERT INTO users(username,password_hash,display_name) VALUES (?,?,?)");
        $ins->execute([$username, $pw_hash, $username]);
        $newId = $pdo->lastInsertId();
        $_SESSION['user_id']  = $newId;
        $_SESSION['username'] = $username;
        echo json_encode(["status"=>"success","message"=>"New user created, logged in", "newUser" => true]);
        exit;
    }
    if (!password_verify($password, $row['password_hash'])) {
        http_response_code(403);
        echo json_encode(["status"=>"error","message"=>"Incorrect password"]);
        exit;
    }
    $_SESSION['user_id']  = $row['id'];
    $_SESSION['username'] = $username;
    echo json_encode(["status"=>"success","message"=>"Logged in"]);
    exit;
}
if ($method==='POST' && $request_uri==='/auth/logout') {
    session_destroy();
    echo json_encode(["status"=>"success","message"=>"Logged out"]);
    exit;
}

/**************************************************************
 * 2) PUBLIC VIEW: /public/{username}
 **************************************************************/
if ($method==='GET' && preg_match('/^\/public\/(.+)/', $request_uri, $m)) {
    $username = $m[1];
    $st = $pdo->prepare("SELECT id,public_listed FROM users WHERE username=?");
    $st->execute([$username]);
    $uRow = $st->fetch(PDO::FETCH_ASSOC);
    if (!$uRow) {
        http_response_code(404);
        echo json_encode(["status"=>"error","message"=>"User not found"]);
        exit;
    }
    if (!$uRow['public_listed']) {
        http_response_code(403);
        echo json_encode(["status"=>"error","message"=>"User is not public"]);
        exit;
    }
    $uid = $uRow['id'];
    $st2 = $pdo->prepare("SELECT symbol,status,description,image_url,quantity,purity,is_wish,wishlist_priority FROM statuses WHERE user_id=?");
    $st2->execute([$uid]);
    $statuses = [];
    while($r = $st2->fetch(PDO::FETCH_ASSOC)){
        $sym = $r['symbol'];
        $statuses[$sym] = [
            "status"      => $r['status'],
            "description" => $r['description'],
            "imageUrl"    => $r['image_url'],
            "quantity"    => (float)$r['quantity'],
            "purity"      => (float)$r['purity'],
            "isWish"      => (bool)$r['is_wish'],
            "wishlistPriority" => (int)$r['wishlist_priority']
        ];
    }
    echo json_encode(["status"=>"success","statuses"=>$statuses]);
    exit;
}

/**************************************************************
 * 3) PUBLICINFO: /publicinfo/{username}
 * Now also returns collection stats.
 **************************************************************/
if ($method==='GET' && preg_match('/^\/publicinfo\/(.+)/', $request_uri, $m)) {
    $username = $m[1];
    $st = $pdo->prepare("SELECT id, display_name, bio, profile_image_url, public_listed FROM users WHERE username=?");
    $st->execute([$username]);
    $row = $st->fetch(PDO::FETCH_ASSOC);
    if(!$row){
        http_response_code(404);
        echo json_encode(["status"=>"error","message"=>"User not found"]);
        exit;
    }
    if(!$row['public_listed']){
        http_response_code(403);
        echo json_encode(["status"=>"error","message"=>"User is not public"]);
        exit;
    }
    // Calculate collection stats
    $stmt = $pdo->prepare("SELECT status FROM statuses WHERE user_id=?");
    $stmt->execute([$row['id']]);
    $pure = $rep = $alloy = 0;
    while($r = $stmt->fetch(PDO::FETCH_ASSOC)){
       if($r['status'] === 'Pure') $pure++;
       if($r['status'] === 'Representative') $rep++;
       if($r['status'] === 'Alloy') $alloy++;
    }
    $total = $pure + $rep + $alloy;
    $collection_stats = [
       "pure_count" => $pure,
       "rep_count"  => $rep,
       "alloy_count" => $alloy,
       "total_collected" => $total
    ];
    $achSt = $pdo->prepare("SELECT badge_name FROM achievements WHERE user_id=?");
    $achSt->execute([$row['id']]);
    $achvs = [];
    while($ar = $achSt->fetch(PDO::FETCH_ASSOC)){
        $achvs[] = $ar['badge_name'];
    }
    echo json_encode([
        "status"           => "success",
        "display_name"     => $row['display_name'],
        "bio"              => $row['bio'],
        "profile_image_url"=> $row['profile_image_url'],
        "achievements"     => $achvs,
        "collection_stats" => $collection_stats
    ]);
    exit;
}

/**************************************************************
 * 4) Serve /uploads/* images
 **************************************************************/
if ($method==='GET' && preg_match('/^\/uploads\/(.+)/', $request_uri, $m)) {
    $filename = $m[1];
    $path = __DIR__ . "/uploads/" . $filename;
    if(!file_exists($path)){
        http_response_code(404);
        echo "File not found";
        exit;
    }
    $mime = mime_content_type($path);
    header("Content-Type: $mime");
    readfile($path);
    exit;
}

/**************************************************************
 * 5) /api/listusers => list all public profiles
 **************************************************************/
if ($method==='GET' && $request_uri === '/api/listusers') {
    $stmt = $pdo->query("SELECT id,username,display_name FROM users WHERE public_listed=1");
    $users = [];
    while($u = $stmt->fetch(PDO::FETCH_ASSOC)){
        $uid = $u['id'];
        $st2 = $pdo->prepare("SELECT status FROM statuses WHERE user_id=?");
        $st2->execute([$uid]);
        $pure = $rep = $alloy = 0;
        while($row = $st2->fetch(PDO::FETCH_ASSOC)){
            if($row['status'] === 'Pure') $pure++;
            if($row['status'] === 'Representative') $rep++;
            if($row['status'] === 'Alloy') $alloy++;
        }
        $total = $pure + $rep + $alloy;
        
        // Get achievements
        $achSt = $pdo->prepare("SELECT badge_name FROM achievements WHERE user_id=?");
        $achSt->execute([$uid]);
        $achievements = [];
        while($achRow = $achSt->fetch(PDO::FETCH_ASSOC)){
            $achievements[] = $achRow['badge_name'];
        }
        
        $users[] = [
          "username" => $u['username'],
          "display_name" => $u['display_name'],
          "pure_count" => $pure,
          "rep_count"  => $rep,
          "alloy_count"=> $alloy,
          "total_collected" => $total,
          "achievements" => $achievements
        ];
    }
    echo json_encode(["status" => "success", "users" => $users]);
    exit;
}

/**************************************************************
 * 6) /api/search?element=SYMBOL => search element across all public collections
 **************************************************************/
if ($method==='GET' && parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/api/search') {
    $query_params = [];
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $query_params);
    $element_symbol = strtoupper($query_params['element'] ?? '');
    
    if (empty($element_symbol)) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Element parameter required"]);
        exit;
    }
    
    $results = [];
    
    // Get all public users who have this element
    $stmt = $pdo->prepare("
        SELECT u.id, u.username, u.display_name, s.status, s.description, s.image_url, s.quantity, s.purity
        FROM users u 
        JOIN statuses s ON u.id = s.user_id 
        WHERE u.public_listed = 1 AND s.symbol = ? AND s.status != ''
        ORDER BY u.username
    ");
    $stmt->execute([$element_symbol]);
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user_id = $row['id'];
        
        // Get secondary samples for this user/element
        $sample_stmt = $pdo->prepare("
            SELECT id, status, description, image_url, quantity, purity, created_at
            FROM samples 
            WHERE user_id = ? AND symbol = ?
            ORDER BY created_at ASC
        ");
        $sample_stmt->execute([$user_id, $element_symbol]);
        
        $samples = [];
        while($sample = $sample_stmt->fetch(PDO::FETCH_ASSOC)) {
            $samples[] = [
                'id' => $sample['id'],
                'status' => $sample['status'],
                'description' => $sample['description'],
                'image_url' => $sample['image_url'],
                'quantity' => $sample['quantity'],
                'purity' => $sample['purity'],
                'created_at' => $sample['created_at']
            ];
        }
        
        $results[] = [
            'user_id' => $user_id,
            'username' => $row['username'],
            'display_name' => $row['display_name'],
            'main_sample' => [
                'status' => $row['status'],
                'description' => $row['description'],
                'image_url' => $row['image_url'],
                'quantity' => $row['quantity'],
                'purity' => $row['purity']
            ],
            'secondary_samples' => $samples,
            'total_samples' => count($samples) + 1 // +1 for main sample
        ];
    }
    
    echo json_encode([
        "status" => "success", 
        "element" => $element_symbol,
        "results" => $results,
        "total_collections" => count($results)
    ]);
    exit;
}

/**************************************************************
 * 7) PROTECTED ROUTES (must be logged in):
 *   - /user (GET/POST)
 *   - /upload/{symbol} (POST)
 *   - /uploadSample/{symbol} (POST) for sample images
 *   - /settings (GET/POST)
 *   - /api/medialist
 *   - /comments + /comments/count
 *   - /samples + /samples/count
 **************************************************************/
if (preg_match('/^\/user$/', $request_uri)) {
    require_login();
    $uid = current_session_user_id();
    if ($method==='GET') {
        $st = $pdo->prepare("SELECT symbol,status,description,image_url,quantity,purity,is_wish,wishlist_priority,last_modified FROM statuses WHERE user_id=?");
        $st->execute([$uid]);
        $statuses = [];
        $lm = "";
        while($r = $st->fetch(PDO::FETCH_ASSOC)){
            $sym = $r['symbol'];
            $statuses[$sym] = [
              "status" => $r['status'],
              "description" => $r['description'],
              "imageUrl" => $r['image_url'],
              "quantity" => (float)$r['quantity'],
              "purity" => (float)$r['purity'],
              "isWish" => (bool)$r['is_wish'],
              "wishlistPriority" => (int)$r['wishlist_priority']
            ];
            if ($r['last_modified'] > $lm) $lm = $r['last_modified'];
        }
        echo json_encode(["status" => "success", "statuses" => $statuses, "last_modified" => $lm]);
        exit;
    } elseif ($method==='POST') {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || !isset($body['statuses'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Invalid input"]);
            exit;
        }
        $statuses = $body['statuses'];
        $ins = $pdo->prepare("
            INSERT INTO statuses (user_id, symbol, status, description, image_url, quantity, purity, is_wish, wishlist_priority, last_modified)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE
                status = VALUES(status),
                description = VALUES(description),
                image_url = VALUES(image_url),
                quantity = VALUES(quantity),
                purity = VALUES(purity),
                is_wish = VALUES(is_wish),
                wishlist_priority = VALUES(wishlist_priority),
                last_modified = NOW()
        ");
        foreach ($statuses as $sym => $o) {
            $sym   = substr($sym, 0, 5);
            $stat  = $o['status'] ?? '';
            $desc  = $o['description'] ?? '';
            $img   = $o['imageUrl'] ?? '';
            $qty   = floatval($o['quantity'] ?? 0);
            $purt  = floatval($o['purity'] ?? 100);
            $wish  = (!empty($o['isWish']) || $stat==='Wish') ? 1 : 0;
            $wprio = intval($o['wishlistPriority'] ?? 0);
            $ins->execute([$uid, $sym, $stat, $desc, $img, $qty, $purt, $wish, $wprio]);
        }
        // achievements
        checkAndAwardAchievements($pdo, $uid);
        echo json_encode(["status" => "success"]);
        exit;
    }
}
if ($method==='POST' && preg_match('/^\/upload\/([^\/]+)/', $request_uri, $m)) {
    require_login();
    $symbol = $m[1];
    $uid = current_session_user_id();
    $uname = current_session_username();
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "No file or error"]);
        exit;
    }
    $max_file_size = 2 * 1024 * 1024;
    if ($_FILES['image']['size'] > $max_file_size) {
        http_response_code(413);
        echo json_encode(["status" => "error", "message" => "File too large (max 2MB)"]);
        exit;
    }
    $filename = basename($_FILES['image']['name']);
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
    $unique = $uname . "_" . $symbol . "_" . $filename;
    $dest = __DIR__ . "/uploads/" . $unique;
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Failed to save file"]);
        exit;
    }
    if ($symbol === 'profile') {
        $st = $pdo->prepare("UPDATE users SET profile_image_url=? WHERE id=?");
        $st->execute(["/uploads/" . $unique, $uid]);
    } else {
        $ins = $pdo->prepare("INSERT INTO statuses
           (user_id, symbol, status, description, image_url, quantity, purity, is_wish, wishlist_priority)
           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
           ON DUPLICATE KEY UPDATE image_url=VALUES(image_url), last_modified=NOW()");
        $ins->execute([$uid, $symbol, '', '', "/uploads/" . $unique, 0, 100, 0, 0]);
    }
    echo json_encode(["status" => "success", "imageUrl" => "/uploads/" . $unique]);
    exit;
}
/* New: Sample file upload endpoint */
if ($method==='POST' && preg_match('/^\/uploadSample\/([^\/]+)/', $request_uri, $m)) {
    require_login();
    $symbol = $m[1];
    $uid = current_session_user_id();
    $uname = current_session_username();
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "No file or error"]);
        exit;
    }
    $max_file_size = 2 * 1024 * 1024;
    if ($_FILES['image']['size'] > $max_file_size) {
        http_response_code(413);
        echo json_encode(["status" => "error", "message" => "File too large (max 2MB)"]);
        exit;
    }
    $filename = basename($_FILES['image']['name']);
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
    $unique = $uname . "_sample_" . $symbol . "_" . $filename;
    $dest = __DIR__ . "/uploads/" . $unique;
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $dest)) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Failed to save file"]);
        exit;
    }
    echo json_encode(["status" => "success", "imageUrl" => "/uploads/" . $unique]);
    exit;
}

/**************************************************************
 * 7) /settings => GET/POST profile
 **************************************************************/
if (preg_match('/^\/settings$/', $request_uri)) {
    $uid = current_session_user_id();
    if ($method==='GET') {
        require_login();
        $stm = $pdo->prepare("SELECT username,display_name,email,bio,profile_image_url,public_listed FROM users WHERE id=?");
        $stm->execute([$uid]);
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "User data not found"]);
            exit;
        }
        echo json_encode(["status" => "success", "user" => $row]);
        exit;
    } elseif ($method==='POST') {
        require_login();
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "No input"]);
            exit;
        }
        $st = $pdo->prepare("SELECT password_hash FROM users WHERE id=?");
        $st->execute([$uid]);
        $urow = $st->fetch(PDO::FETCH_ASSOC);
        if (!$urow) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "User not found"]);
            exit;
        }
        if (!empty($body['oldPassword']) && !empty($body['newPassword'])) {
            if (!password_verify($body['oldPassword'], $urow['password_hash'])) {
                http_response_code(403);
                echo json_encode(["status" => "error", "message" => "Incorrect old password"]);
                exit;
            }
            $newHash = password_hash($body['newPassword'], PASSWORD_BCRYPT);
            $pdo->prepare("UPDATE users SET password_hash=? WHERE id=?")->execute([$newHash, $uid]);
        }
        $dn = $body['display_name'] ?? '';
        $em = $body['email'] ?? '';
        $b = $body['bio'] ?? '';
        $pl = !empty($body['public_listed']) ? 1 : 0;
        $pdo->prepare("UPDATE users SET display_name=?,email=?,bio=?,public_listed=? WHERE id=?")
            ->execute([$dn, $em, $b, $pl, $uid]);
        echo json_encode(["status" => "success", "message" => "Profile updated"]);
        exit;
    }
}

/**************************************************************
 * 8) /api/medialist => GET/DELETE media list
 **************************************************************/
if (preg_match('/^\/api\/medialist$/', $request_uri)) {
    require_login();
    $uid = current_session_user_id();
    $uname = current_session_username();
    if ($method==='GET') {
        $files = glob(__DIR__ . "/uploads/" . $uname . "_*");
        $res = [];
        foreach ($files as $f) {
            $base = basename($f);
            $res[] = ["filename" => $base, "url" => "/uploads/" . $base];
        }
        echo json_encode(["status" => "success", "files" => $res]);
        exit;
    } elseif ($method==='DELETE') {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || empty($body['filename'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "No filename"]);
            exit;
        }
        $filename = $body['filename'];
        if (strpos($filename, $uname . "_") !== 0) {
            http_response_code(403);
            echo json_encode(["status" => "error", "message" => "File not owned by user"]);
            exit;
        }
        $path = __DIR__ . "/uploads/" . $filename;
        if (!file_exists($path)) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "File not found"]);
            exit;
        }
        unlink($path);
        echo json_encode(["status" => "success", "message" => "File deleted"]);
        exit;
    }
}

/**************************************************************
 * COMMENTS Endpoints
 **************************************************************/
if (preg_match('/^\/comments$/', $request_uri)) {
    if ($method==='POST') {
        // Force login for posting comments.
        require_login();
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || empty($body['ownerUsername']) || empty($body['symbol']) || empty($body['commentText'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Missing fields"]);
            exit;
        }
        $ownerUN = $body['ownerUsername'];
        $symbol  = $body['symbol'];
        $comment = $body['commentText'];
        $st = $pdo->prepare("SELECT id,public_listed FROM users WHERE username=?");
        $st->execute([$ownerUN]);
        $oRow = $st->fetch(PDO::FETCH_ASSOC);
        if (!$oRow) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "Owner not found"]);
            exit;
        }
        if (!$oRow['public_listed']) {
            if ($oRow['id'] != current_session_user_id()) {
                http_response_code(403);
                echo json_encode(["status" => "error", "message" => "Owner not public"]);
                exit;
            }
        }
        $ownerId = $oRow['id'];
        $commenter = current_session_username();
        $ins = $pdo->prepare("INSERT INTO comments(owner_user_id,symbol,commenter_username,comment_text) VALUES(?,?,?,?)");
        $ins->execute([$ownerId, $symbol, $commenter, $comment]);
        echo json_encode(["status" => "success", "message" => "Comment posted"]);
        exit;
    } elseif ($method==='GET') {
        $ownerUN = $_GET['ownerUsername'] ?? '';
        $symbol = $_GET['symbol'] ?? '';
        if (!$ownerUN || !$symbol) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "Must provide ownerUsername & symbol"]);
            exit;
        }
        $st = $pdo->prepare("SELECT id, public_listed FROM users WHERE username=?");
        $st->execute([$ownerUN]);
        $oRow = $st->fetch(PDO::FETCH_ASSOC);
        if (!$oRow) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "No public user found"]);
            exit;
        }
        if (!$oRow['public_listed']) {
            if ($oRow['id'] != current_session_user_id()) {
                http_response_code(404);
                echo json_encode(["status" => "error", "message" => "User not public"]);
                exit;
            }
        }
        $ownerId = $oRow['id'];
        $st2 = $pdo->prepare("SELECT commenter_username,comment_text,created_at FROM comments WHERE owner_user_id=? AND symbol=? ORDER BY created_at ASC");
        $st2->execute([$ownerId, $symbol]);
        $rows = $st2->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(["status" => "success", "comments" => $rows]);
        exit;
    }
}
if ($method==='GET' && preg_match('/^\/comments\/count$/', $request_uri)) {
    $ownerUN = $_GET['ownerUsername'] ?? '';
    if (!$ownerUN) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Must provide ownerUsername"]);
        exit;
    }
    $st = $pdo->prepare("SELECT id,public_listed FROM users WHERE username=?");
    $st->execute([$ownerUN]);
    $oRow = $st->fetch(PDO::FETCH_ASSOC);
    if (!$oRow) {
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "No public user found or user does not exist"]);
        exit;
    }
    if (!$oRow['public_listed']) {
        if ($oRow['id'] != current_session_user_id()) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "User not public"]);
            exit;
        }
    }
    $ownerId = $oRow['id'];
    $st2 = $pdo->prepare("SELECT symbol, COUNT(*) as cnt FROM comments WHERE owner_user_id=? GROUP BY symbol");
    $st2->execute([$ownerId]);
    $counts = [];
    while ($r = $st2->fetch(PDO::FETCH_ASSOC)) {
        $counts[$r['symbol']] = (int)$r['cnt'];
    }
    echo json_encode(["status" => "success", "counts" => $counts]);
    exit;
}

/**************************************************************
 * NEW: SAMPLES Endpoints
 **************************************************************/
if ($method==='GET' && preg_match('/^\/samples$/', $request_uri)) {
    $ownerUN = $_GET['ownerUsername'] ?? '';
    $symbol = $_GET['symbol'] ?? '';
    if (!$ownerUN || !$symbol) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Must provide ownerUsername and symbol"]);
        exit;
    }
    $st = $pdo->prepare("SELECT id, public_listed FROM users WHERE username=?");
    $st->execute([$ownerUN]);
    $oRow = $st->fetch(PDO::FETCH_ASSOC);
    if (!$oRow) {
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "User not found"]);
        exit;
    }
    if (!$oRow['public_listed'] && $oRow['id'] != current_session_user_id()) {
        http_response_code(403);
        echo json_encode(["status" => "error", "message" => "User not public"]);
        exit;
    }
    $ownerId = $oRow['id'];
    $st2 = $pdo->prepare("SELECT id, status, description, image_url, quantity, purity, created_at FROM samples WHERE user_id=? AND symbol=? ORDER BY created_at ASC");
    $st2->execute([$ownerId, $symbol]);
    $samples = [];
    while ($r = $st2->fetch(PDO::FETCH_ASSOC)) {
        $samples[] = $r;
    }
    echo json_encode(["status" => "success", "samples" => $samples]);
    exit;
}
if ($method==='POST' && preg_match('/^\/samples$/', $request_uri)) {
    require_login();
    $uid = current_session_user_id();
    $body = json_decode(file_get_contents('php://input'), true);
    if (!$body || empty($body['symbol'])) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Missing fields: symbol required"]);
        exit;
    }
    $symbol = substr($body['symbol'], 0, 5);
    $status = $body['status'] ?? '';
    $description = $body['description'] ?? '';
    $imageUrl = $body['imageUrl'] ?? '';
    $quantity = floatval($body['quantity'] ?? 0);
    $purity = floatval($body['purity'] ?? 100);
    $ins = $pdo->prepare("INSERT INTO samples (user_id, symbol, status, description, image_url, quantity, purity) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $ins->execute([$uid, $symbol, $status, $description, $imageUrl, $quantity, $purity]);
    echo json_encode(["status" => "success", "message" => "Sample added"]);
    exit;
}
if ($method==='GET' && preg_match('/^\/samples\/count$/', $request_uri)) {
    $ownerUN = $_GET['ownerUsername'] ?? '';
    if (!$ownerUN) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Must provide ownerUsername"]);
        exit;
    }
    $st = $pdo->prepare("SELECT id, public_listed FROM users WHERE username=?");
    $st->execute([$ownerUN]);
    $oRow = $st->fetch(PDO::FETCH_ASSOC);
    if (!$oRow) {
        http_response_code(404);
        echo json_encode(["status" => "error", "message" => "User not found"]);
        exit;
    }
    if (!$oRow['public_listed'] && $oRow['id'] != current_session_user_id()) {
        http_response_code(403);
        echo json_encode(["status" => "error", "message" => "User not public"]);
        exit;
    }
    $ownerId = $oRow['id'];
    $st2 = $pdo->prepare("SELECT symbol, COUNT(*) as cnt FROM samples WHERE user_id=? GROUP BY symbol");
    $st2->execute([$ownerId]);
    $counts = [];
    while ($r = $st2->fetch(PDO::FETCH_ASSOC)) {
        $counts[$r['symbol']] = (int)$r['cnt'];
    }
    echo json_encode(["status" => "success", "counts" => $counts]);
    exit;
}

/**************************************************************
 * NEW: SAMPLE EDIT/DELETE Endpoints
 **************************************************************/
if ($method==='PUT' && preg_match('/^\/samples\/(\d+)$/', $request_uri, $m)) {
    require_login();
    $sampleId = intval($m[1]);
    $uid = current_session_user_id();
    $body = json_decode(file_get_contents('php://input'), true);
    $st = $pdo->prepare("SELECT * FROM samples WHERE id = ? AND user_id = ?");
    $st->execute([$sampleId, $uid]);
    $sample = $st->fetch(PDO::FETCH_ASSOC);
    if (!$sample) {
       http_response_code(404);
       echo json_encode(["status" => "error", "message" => "Sample not found or not owned by user"]);
       exit;
    }
    $status = $body['status'] ?? $sample['status'];
    $description = $body['description'] ?? $sample['description'];
    $imageUrl = $body['imageUrl'] ?? $sample['image_url'];
    $quantity = floatval($body['quantity'] ?? $sample['quantity']);
    $purity = floatval($body['purity'] ?? $sample['purity']);
    $upd = $pdo->prepare("UPDATE samples SET status=?, description=?, image_url=?, quantity=?, purity=? WHERE id=?");
    $upd->execute([$status, $description, $imageUrl, $quantity, $purity, $sampleId]);
    echo json_encode(["status" => "success", "message" => "Sample updated"]);
    exit;
}

if ($method==='DELETE' && preg_match('/^\/samples\/(\d+)$/', $request_uri, $m)) {
    require_login();
    $sampleId = intval($m[1]);
    $uid = current_session_user_id();
    $st = $pdo->prepare("SELECT * FROM samples WHERE id = ? AND user_id = ?");
    $st->execute([$sampleId, $uid]);
    $sample = $st->fetch(PDO::FETCH_ASSOC);
    if (!$sample) {
       http_response_code(404);
       echo json_encode(["status" => "error", "message" => "Sample not found or not owned by user"]);
       exit;
    }
    $imageUrl = $sample['image_url'];
    if ($imageUrl && strpos($imageUrl, '/uploads/') === 0) {
         $filePath = __DIR__ . $imageUrl;
         if (file_exists($filePath)) {
             unlink($filePath);
         }
    }
    $del = $pdo->prepare("DELETE FROM samples WHERE id=?");
    $del->execute([$sampleId]);
    echo json_encode(["status" => "success", "message" => "Sample deleted"]);
    exit;
}

/**************************************************************
 * 7) /settings => GET/POST profile
 **************************************************************/
if (preg_match('/^\/settings$/', $request_uri)) {
    $uid = current_session_user_id();
    if ($method==='GET') {
        require_login();
        $stm = $pdo->prepare("SELECT username,display_name,email,bio,profile_image_url,public_listed FROM users WHERE id=?");
        $stm->execute([$uid]);
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "User data not found"]);
            exit;
        }
        echo json_encode(["status" => "success", "user" => $row]);
        exit;
    } elseif ($method==='POST') {
        require_login();
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "No input"]);
            exit;
        }
        $st = $pdo->prepare("SELECT password_hash FROM users WHERE id=?");
        $st->execute([$uid]);
        $urow = $st->fetch(PDO::FETCH_ASSOC);
        if (!$urow) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "User not found"]);
            exit;
        }
        if (!empty($body['oldPassword']) && !empty($body['newPassword'])) {
            if (!password_verify($body['oldPassword'], $urow['password_hash'])) {
                http_response_code(403);
                echo json_encode(["status" => "error", "message" => "Incorrect old password"]);
                exit;
            }
            $newHash = password_hash($body['newPassword'], PASSWORD_BCRYPT);
            $pdo->prepare("UPDATE users SET password_hash=? WHERE id=?")->execute([$newHash, $uid]);
        }
        $dn = $body['display_name'] ?? '';
        $em = $body['email'] ?? '';
        $b = $body['bio'] ?? '';
        $pl = !empty($body['public_listed']) ? 1 : 0;
        $pdo->prepare("UPDATE users SET display_name=?,email=?,bio=?,public_listed=? WHERE id=?")
            ->execute([$dn, $em, $b, $pl, $uid]);
        echo json_encode(["status" => "success", "message" => "Profile updated"]);
        exit;
    }
}

/**************************************************************
 * 8) /api/medialist => GET/DELETE media list
 **************************************************************/
if (preg_match('/^\/api\/medialist$/', $request_uri)) {
    require_login();
    $uid = current_session_user_id();
    $uname = current_session_username();
    if ($method==='GET') {
        $files = glob(__DIR__ . "/uploads/" . $uname . "_*");
        $res = [];
        foreach ($files as $f) {
            $base = basename($f);
            $res[] = ["filename" => $base, "url" => "/uploads/" . $base];
        }
        echo json_encode(["status" => "success", "files" => $res]);
        exit;
    } elseif ($method==='DELETE') {
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body || empty($body['filename'])) {
            http_response_code(400);
            echo json_encode(["status" => "error", "message" => "No filename"]);
            exit;
        }
        $filename = $body['filename'];
        if (strpos($filename, $uname . "_") !== 0) {
            http_response_code(403);
            echo json_encode(["status" => "error", "message" => "File not owned by user"]);
            exit;
        }
        $path = __DIR__ . "/uploads/" . $filename;
        if (!file_exists($path)) {
            http_response_code(404);
            echo json_encode(["status" => "error", "message" => "File not found"]);
            exit;
        }
        unlink($path);
        echo json_encode(["status" => "success", "message" => "File deleted"]);
        exit;
    }
}

/**************************************************************
 * If no route matched
 **************************************************************/
http_response_code(404);
echo json_encode(["status" => "error", "message" => "Invalid endpoint"]);

/**************************************************************
 * ACHIEVEMENTS
 **************************************************************/
function checkAndAwardAchievements(PDO $pdo, int $uid){
    $st = $pdo->prepare("SELECT symbol,status FROM statuses WHERE user_id=?");
    $st->execute([$uid]);
    $collected = [];
    while ($r = $st->fetch(PDO::FETCH_ASSOC)) {
        if (in_array($r['status'], ['Pure','Alloy','Representative'])) {
            $collected[] = strtoupper($r['symbol']);
        }
    }
    $collected = array_unique($collected);
    $alkali = ['LI','NA','K','RB','CS'];
    $nobles = ['HE','NE','AR','KR','XE'];
    $first10 = ['H','HE','LI','BE','B','C','N','O','F','NE'];
    if (count(array_intersect($alkali, $collected)) === count($alkali)) {
        awardBadge($pdo, $uid, "All Alkali Metals");
    }
    if (count(array_intersect($nobles, $collected)) === count($nobles)) {
        awardBadge($pdo, $uid, "All Noble Gases");
    }
    $c10 = 0;
    foreach ($first10 as $x) {
        if (in_array($x, $collected)) $c10++;
    }
    if ($c10 === 10) {
        awardBadge($pdo, $uid, "First 10 Elements");
    }
}
function awardBadge(PDO $pdo, int $uid, string $badge){
    $st = $pdo->prepare("SELECT id FROM achievements WHERE user_id=? AND badge_name=?");
    $st->execute([$uid, $badge]);
    if (!$st->fetch()) {
        $ins = $pdo->prepare("INSERT INTO achievements(user_id,badge_name) VALUES(?,?)");
        $ins->execute([$uid, $badge]);
    }
}
?>
