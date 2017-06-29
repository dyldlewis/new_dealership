<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Car.php";

    $app = new Silex\Application();

    $app->get("/", function() {
        return $app["twig"]->render("car_form.html.twig", array("cars" => Car::getAll()));
    });


    $app->get("/vehicular_view", function() {
        $header = "
        <!DOCTYPE html><html>
        <head>
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css'>
            <title>Find a Car</title>
        </head>
        <body><div class='container'>";
        $footer = "</div></body></html>";
        $porsche = new Car("2014 Porsche 911", 114991.00, 7864, "/../img/porsche.jpg");
        $ford = new Car("2011 Ford F450", 55995.00, 14241, "/../img/ford.jpg");
        $lexus = new Car("2013 Lexus RX 350", 44700.00, 20000, "/../img/lexus.jpg");
        $mercedes = new Car("Mercedes Benz CLS550", 39900.00, 37979, "/../img/mercedes.jpg");
        $porsche->setPrice("100000.00");
        $cars = array($porsche, $ford, $lexus, $mercedes);
        $cars_matching_search = array();
        foreach ($cars as $car) {
            if ($car->worthBuying($_GET["price"])){
            array_push($cars_matching_search, $car);
            }
        }
        if (count($cars_matching_search) == 0) {
            return '<h2> No cars matched your search. </h2>';
        } else {
            $soln = "";
            foreach ($cars_matching_search as $car) {
                $car_model = $car->getMakeModel();
                $car_price = $car->getPrice();
                $car_miles = $car->getMiles();
                $car_img = $car->getImage();
                $soln = $soln . '<ul class="list-unstyled">
                            <li>' . $car_model . '</li>
                                <ul>
                                    <li> $' . $car_price . '</li>
                                    <li> Miles: ' . $car_miles . '</li>
                                    <li> <img src=' . $car_img . '>  </li>
                                </ul>
                        </ul>';
            };
            return $header . $soln . $footer;
        }
    });
    return $app;
?>
