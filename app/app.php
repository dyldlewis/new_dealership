<?php
    date_default_timezone_set("America/Los_Angeles");
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Car.php";

    session_start();

    if(empty($_SESSION['saved_cars'])) {
      $_SESSION['saved_cars'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array("twig.path" => __DIR__."/../views"
    ));

    $app->get("/", function() use ($app) {
        return $app["twig"]->render("car_form.html.twig");
    });

    // $porsche = new Car("2014 Porsche 911", 114991.00, 7864, "/../img/porsche.jpg");
    // $ford = new Car("2011 Ford F450", 55995.00, 14241, "/../img/ford.jpg");
    // $lexus = new Car("2013 Lexus RX 350", 44700.00, 20000, "/../img/lexus.jpg");
    // $mercedes = new Car("Mercedes Benz CLS550", 39900.00, 37979, "/../img/mercedes.jpg");
    //
    // $porsche->save();
    // $ford->save();
    // $lexus->save();
    // $mercedes->save();

    $app->post("/vehicular_view", function() use ($app) {
        // array_push($_SESSION['saved_cars'] ($porsche, $ford, $lexus, $mercedes));
        // foreach ($cars_arr as $car) {
        //     $car->save();
        // }
        // $porsche->setPrice("100000.00");
        $cars = Car::getAll();
        // var_dump($cars);
        // var_dump($_SESSION['saved_cars']);

        $cars_matching_search = array();
        foreach ($cars as $car) {
            if ($car->worthBuying($_POST["price"])){
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
            return $soln;
        }
    });

    $app->post("/sell_car", function() use ($app) {
        $new_car = new Car($_POST['make-model'], $_POST['mileage'],$_POST['price'],$_POST['image']);
        $new_car->save();
        return $app["twig"]->render("new_car.html.twig", array("new_car" => $new_car));
    });

    return $app;
?>
