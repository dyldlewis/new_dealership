<?php
class Car
{
    private $make_model;
    private $image;
    private $price;
    private $miles;

    function worthBuying($max_price)
    {
        return $this->price < ($max_price + 100);
    }

    function __construct($make_model, $price, $miles)
    {
        $this->make_model = $make_model;
        // $this->image = $image_path;
        $this->price = $price;
        $this->miles = $miles;
    }

    function getMakeModel()
    {
        return $this->make_model;
    }

    function getImage()
    {
        return $this->image_path;
    }

    function getPrice()
    {
        return $this->price;
    }

    function getMiles()
    {
        return $this->miles;
    }

    // function setMakeModel($new_make_model)
    // {
    //     if ($new_make_model != "") {
    //         $this->make_model = $new_make_model;
    //     }
    // }

    function setImage($new_image_path)
    {
        if ($new_image_path != "") {
            $this->image_path = $new_image_path;
        }
    }

    function setPrice($new_price)
    {
        if ($new_price != 0) {
            $this->price = $new_price;
        }
    }

    function setMiles($new_miles)
    {
        if ($new_miles != 0) {
            $this->miles = $new_miles;
        }
    }
}


$porsche = new Car("2014 Porsche 911", 114991, 7864);

$ford = new Car("2011 Ford F450", 55995, 14241);

$lexus = new Car("2013 Lexus RX 350", 44700, 20000);

$mercedes = new Car("Mercedes Benz CLS550", 39900, 37979);

$cars = array($porsche, $ford, $lexus, $mercedes);

$cars_matching_search = array();
foreach ($cars as $car) {
    if ($car->worthBuying($_GET["price"])) {
        array_push($cars_matching_search, $car);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Car Dealership's Homepage</title>
</head>
<body>
    <h1>Your Car Dealership</h1>
    <ul>
        <?php
            foreach ($cars_matching_search as $car) {
              $car_make_model = $car->getMakeModel();
              $car_price = $car->getPrice();
              $car_miles = $car->getMiles();
                echo "<li> $car_make_model </li>";
                echo "<ul>";
                    echo "<li> $$car_price </li>";
                    echo "<li> Miles: $car_miles </li>";
                echo "</ul>";
            }
        ?>
    </ul>
</body>
</html>
