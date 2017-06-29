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

    $app->post("/vehicular_view", function() use ($app) {
        $cars = Car::getAll();

        $cars_matching_search = array();
        foreach ($cars as $car) {
            if ($car->worthBuying($_POST["price"])){
            array_push($cars_matching_search, $car);
            }
        }
        return $app["twig"]->render("display_cars.html.twig", array("car_array" => $cars_matching_search));
    });

    $app->post("/sell_car", function() use ($app) {
        $new_car = new Car($_POST['make-model'], $_POST['mileage'], $_POST['price'], $_POST['image']);
        $new_car->save();
        return $app["twig"]->render("new_car.html.twig", array("new_car" => $new_car));
    });

    return $app;
?>
