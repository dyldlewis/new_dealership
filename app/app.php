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
        $cars = Car::getAll();

        $cars_matching_search = array();
        foreach ($cars as $car) {
            if ($car->worthBuying($_POST["price"])){
            array_push($cars_matching_search, $car);
            }
        }
        return $app["twig"]->render("display_cars.html.twig", array("car_array" => $cars));
    });

    $app->post("/sell_car", function() use ($app) {
        $new_car = new Car($_POST['make-model'], $_POST['mileage'],$_POST['price'],$_POST['image']);
        $new_car->save();
        return $app["twig"]->render("new_car.html.twig", array("new_car" => $new_car));
    });

    return $app;
?>
