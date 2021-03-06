<?php
    class Car
    {
        private $make_model;
        private $miles;
        private $price;
        private $image_path;
        function __construct($make_model, $miles, $price, $image_path)

        {
            $this->make_model = $make_model;
            $this->miles = $miles;
            $this->price = $price;
            $this->image_path = $image_path;
        }

        function getMakeModel()
        {
            return $this->make_model;
        }

        function setPrice($new_price)
        {
            $float_price = (float) $new_price;
            if ($float_price != 0) {
                 $this->price = $float_price;
            }
        }

        function getPrice()
        {
            return $this->price;
        }

        function getMiles()
        {
            return $this->miles;
        }

        function getImage()
        {
            return $this->image_path;
        }
        
        function worthBuying($max_price)
        {
            return $this->price < ($max_price + 100);
        }

        function save()
        {
            array_push($_SESSION['saved_cars'], $this);
        }

        static function getAll()
        {
            return $_SESSION['saved_cars'];
        }

        static function deleteAll()
        {
            return $_SESSION['saved_cars'] = array();
        }
    }
?>
