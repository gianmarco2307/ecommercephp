<?php

class Product {
    public $qty;
    public $userId;
    public $title;
    public $description;
    public $id;
    public $price;
    public $image;
    public $thumbnail;
}

class Products {
    protected $url;
    protected $data;

    public $products = array();
    
    public function __construct()
    {
        $this->url = "https://mockend.up.railway.app/api/products";
        $response = file_get_contents($this->url);
        $this->data = json_decode($response, true);

        foreach ($this->data as $valore) {
            $product = new Product();
            $product->qty = $valore['qty'];
            $product->userId = $valore['userId'];
            $product->title = $valore['title'];
            $product->description = $valore['description'];
            $product->id = $valore['id'];
            $product->price = $valore['price'];
            $product->image = $valore['image'];
            $product->thumbnail = $valore['thumbnail'];
            $this->addProduct($product);
        }
    }
    
    private function addProduct($product) {
        $this->products[] = $product;
    }
}

class Cart {
    public $products = array();
    
    public function addProductInCart($product) {
        $this->products[] = $product;
    }
}

echo '<link rel="stylesheet" href="styles.css">';

$products = new Products();
$cart = new Cart();
echo "<h1>Prodotti: ".count($products->products)."</h1>";

$divContent = "<div id='content'>";
foreach ($products->products as $product) {
    $divPost = "<div class='post'>";
    $divPost .= "<img src='" . $product->thumbnail . "' class='img'><br>";
    $divPost .= "<h2>" . $product->title . "</h2>";
    $divPost .= "<p id='description'>".$product->description."</p>";
    $divPost .= "<p id='price' onclick='".$cart->addProductInCart($product)."'> Prezzo: ".$product->price."</p>";
    $divPost .= "</div>";
    $divContent .= $divPost;
}

$divContent .= "</div>";

echo $divContent;
echo "<script>console.log(".json_encode($cart->products).")</script>";