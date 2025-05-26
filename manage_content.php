<?php
require_once 'db_connect.php';

header('Content-Type: text/plain');

try {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        // Products
        case 'add_product':
            $name = $_POST['name'];
            $price = $_POST['price'];
            $image = $_POST['image'];
            
            $stmt = $pdo->prepare("INSERT INTO products (name, price, image_path) VALUES (?, ?, ?)");
            $stmt->execute([$name, $price, $image]);
            echo "success";
            break;
            
        case 'update_product':
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];
            $image = $_POST['image'];
            
            $stmt = $pdo->prepare("UPDATE products SET name = ?, price = ?, image_path = ? WHERE id = ?");
            $stmt->execute([$name, $price, $image, $id]);
            echo "success";
            break;
            
        case 'remove_product':
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$id]);
            echo "success";
            break;
            
        // Research Categories
        case 'add_category':
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            $stmt = $pdo->prepare("INSERT INTO research_categories (title, description) VALUES (?, ?)");
            $stmt->execute([$title, $description]);
            echo "success";
            break;
            
        case 'update_category':
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            $stmt = $pdo->prepare("UPDATE research_categories SET title = ?, description = ? WHERE id = ?");
            $stmt->execute([$title, $description, $id]);
            echo "success";
            break;
            
        case 'remove_category':
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM research_categories WHERE id = ?");
            $stmt->execute([$id]);
            echo "success";
            break;
            
        // Research Papers
        case 'add_paper':
            $title = $_POST['title'];
            $publication = $_POST['publication'];
            $abstract = $_POST['description'];
            $link = $_POST['link'];
            
            $stmt = $pdo->prepare("INSERT INTO research_papers (title, publication_info, abstract, link) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $publication, $abstract, $link]);
            echo "success";
            break;
            
        case 'update_paper':
            $id = $_POST['id'];
            $title = $_POST['title'];
            $publication = $_POST['publication'];
            $abstract = $_POST['description'];
            $link = $_POST['link'];
            
            $stmt = $pdo->prepare("UPDATE research_papers SET title = ?, publication_info = ?, abstract = ?, link = ? WHERE id = ?");
            $stmt->execute([$title, $publication, $abstract, $link, $id]);
            echo "success";
            break;
            
        case 'remove_paper':
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM research_papers WHERE id = ?");
            $stmt->execute([$id]);
            echo "success";
            break;
            
        // Demo Projects
        case 'add_project':
            $title = $_POST['title'];
            $description = $_POST['description'];
            $youtube = $_POST['youtube'];
            $details = $_POST['details'];
            
            $stmt = $pdo->prepare("INSERT INTO demo_projects (title, description, youtube_url, details) VALUES (?, ?, ?, ?)");
            $stmt->execute([$title, $description, $youtube, $details]);
            echo "success";
            break;
            
        case 'update_project':
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $youtube = $_POST['youtube'];
            $details = $_POST['details'];
            
            $stmt = $pdo->prepare("UPDATE demo_projects SET title = ?, description = ?, youtube_url = ?, details = ? WHERE id = ?");
            $stmt->execute([$title, $description, $youtube, $details, $id]);
            echo "success";
            break;
            
        case 'remove_project':
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM demo_projects WHERE id = ?");
            $stmt->execute([$id]);
            echo "success";
            break;
            
        // Cart
        case 'save_cart':
            $cartData = $_POST['cart_data'];
            $sessionId = session_id();
            
            // Check if cart exists for this session
            $stmt = $pdo->prepare("SELECT id FROM user_carts WHERE session_id = ?");
            $stmt->execute([$sessionId]);
            
            if ($stmt->rowCount() > 0) {
                // Update existing cart
                $stmt = $pdo->prepare("UPDATE user_carts SET cart_data = ? WHERE session_id = ?");
                $stmt->execute([$cartData, $sessionId]);
            } else {
                // Create new cart
                $stmt = $pdo->prepare("INSERT INTO user_carts (session_id, cart_data) VALUES (?, ?)");
                $stmt->execute([$sessionId, $cartData]);
            }
            echo "success";
            break;
        // Emerging Trends
        case 'add_trend':
            $url = $_POST['url'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            $stmt = $pdo->prepare("INSERT INTO emerging_trends (content_url, title, description) VALUES (?, ?, ?)");
            $stmt->execute([$url, $title, $description]);
            echo "success";
            break;
            
        case 'update_trend':
            $id = $_POST['id'];
            $url = $_POST['url'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            $stmt = $pdo->prepare("UPDATE emerging_trends SET content_url = ?, title = ?, description = ? WHERE id = ?");
            $stmt->execute([$url, $title, $description, $id]);
            echo "success";
            break;
            
        case 'remove_trend':
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM emerging_trends WHERE id = ?");
            $stmt->execute([$id]);
            echo "success";
            break;
            
        // Video Tutorials
        case 'add_video':
            $url = $_POST['url'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            $stmt = $pdo->prepare("INSERT INTO video_tutorials (embed_url, title, description) VALUES (?, ?, ?)");
            $stmt->execute([$url, $title, $description]);
            echo "success";
            break;
            
        case 'update_video':
            $id = $_POST['id'];
            $url = $_POST['url'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            
            $stmt = $pdo->prepare("UPDATE video_tutorials SET embed_url = ?, title = ?, description = ? WHERE id = ?");
            $stmt->execute([$url, $title, $description, $id]);
            echo "success";
            break;
            
        case 'remove_video':
            $id = $_POST['id'];
            $stmt = $pdo->prepare("DELETE FROM video_tutorials WHERE id = ?");
            $stmt->execute([$id]);
            echo "success";
            break;
            
        default:
            echo "Invalid action";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>