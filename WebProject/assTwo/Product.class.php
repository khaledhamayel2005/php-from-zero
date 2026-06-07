<?php
class Product
{
    private $productId;
    private $productName;
    private $category;
    private $description;
    private $price;
    private $quantity;
    private $rating;
    private $photo1;
    private $photo2;
    private $photo3;
    private $defaultPhoto;

    public function __construct($productId = null, $productName = null, $category = null, $description = null, $price = null, $quantity = null, $rating = null, $photo1 = null, $photo2 = null, $photo3 = null, $defaultPhoto = null)
    {
        if ($productId !== null) {
            $this->productId = $productId;
            $this->productName = $productName;
            $this->category = $category;
            $this->description = $description;
            $this->price = $price;
            $this->quantity = $quantity;
            $this->rating = $rating;
            $this->photo1 = $photo1;
            $this->photo2 = $photo2;
            $this->photo3 = $photo3;
            $this->defaultPhoto = $defaultPhoto;
        }
    }

    private function h($value)
    {
        return htmlspecialchars((string)$value);
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function getPhoto1()
    {
        return $this->photo1;
    }

    public function setPhoto1($photo1)
    {
        $this->photo1 = $photo1;
    }

    public function getPhoto2()
    {
        return $this->photo2;
    }

    public function setPhoto2($photo2)
    {
        $this->photo2 = $photo2;
    }

    public function getPhoto3()
    {
        return $this->photo3;
    }

    public function setPhoto3($photo3)
    {
        $this->photo3 = $photo3;
    }

    public function getDefaultPhoto()
    {
        return $this->defaultPhoto;
    }

    public function setDefaultPhoto($defaultPhoto)
    {
        $this->defaultPhoto = $defaultPhoto;
    }

    public function displayInTable()
    {
        // Make one product row for products table.
        $id = $this->h($this->productId);
        $role = '';
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            $role = $_SESSION['role'];
        }

        $html = '<tr>';
        $html .= '<td><img src="images/' . $this->h($this->defaultPhoto) . '" alt="' . $this->h($this->productName) . '" width="90" height="70"></td>';
        $html .= '<td><a href="view.php?id=' . $id . '">' . $id . '</a></td>';
        $html .= '<td>' . $this->h($this->productName) . '</td>';
        $html .= '<td>' . $this->h($this->category) . '</td>';
        $html .= '<td>' . number_format((float)$this->price, 2) . '</td>';
        $html .= '<td>' . $this->h($this->quantity) . '</td>';
        $html .= '<td>';
        $html .= '<a href="view.php?id=' . $id . '">View</a>';
        if ($role === 'Employee') {
            $html .= ' | <a href="edit.php?id=' . $id . '">Edit</a>';
        } else {
            $html .= ' | <a href="add_to_basket.php?id=' . $id . '">Add to Basket</a>';
        }
        $html .= '</td>';
        $html .= '</tr>';

        return $html;
    }

    public function displayProductPage()
    {
        // Make full product page for view.php.
        $isEmployee = false;
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && $_SESSION['role'] === 'Employee') {
            $isEmployee = true;
        }

        $editable = $isEmployee ? '' : ' disabled';
        $id = $this->h($this->productId);
        $html = '<main>';
        $html .= '<article>';
        $html .= '<h2>' . $this->h($this->productName) . '</h2>';
        $html .= '<figure>';
        $html .= '<img src="images/' . $this->h($this->defaultPhoto) . '" alt="' . $this->h($this->productName) . '" width="250" height="180">';
        $html .= '</figure>';
        $html .= '<form method="post" action="edit.php">';
        $html .= '<input type="hidden" name="product_id" value="' . $id . '">';
        $html .= '<p><label>Product ID <input type="text" value="' . $id . '" disabled></label></p>';
        $html .= '<p><label>Product Name <input type="text" value="' . $this->h($this->productName) . '" disabled></label></p>';
        $html .= '<p><label>Category <select disabled><option selected>' . $this->h($this->category) . '</option></select></label></p>';
        $html .= '<p><label>Description<br><textarea name="description" rows="5" cols="50"' . $editable . '>' . $this->h($this->description) . '</textarea></label></p>';
        $html .= '<p><label>Price <input type="number" name="price" step="0.01" value="' . $this->h($this->price) . '"' . $editable . '></label></p>';
        $html .= '<p><label>Quantity <input type="number" name="quantity" value="' . $this->h($this->quantity) . '"' . $editable . '></label></p>';
        $html .= '<p><label>Rating <input type="text" value="' . $this->h($this->rating) . '" disabled></label></p>';
        $html .= '<fieldset>';
        $html .= '<legend>Photos</legend>';
        $photos = array(1 => $this->photo1, 2 => $this->photo2, 3 => $this->photo3);
        foreach ($photos as $number => $photo) {
            $checked = '';
            if ($photo === $this->defaultPhoto) {
                $checked = ' checked';
            }
            $html .= '<label><input type="radio" name="default_photo" value="' . $number . '"' . $checked . $editable . '> Photo ' . $number . '</label> ';
        }
        $html .= '</fieldset>';
        if ($isEmployee) {
            $html .= '<p><input type="submit" value="Save Changes"></p>';
        }
        $html .= '</form>';
        $html .= '<p><a href="products.php">Back to Products</a></p>';
        if (!$isEmployee) {
            $html .= '<p><a href="add_to_basket.php?id=' . $id . '">Add to Basket</a></p>';
        }
        $html .= '</article>';
        $html .= '</main>';

        return $html;
    }
}
?>
