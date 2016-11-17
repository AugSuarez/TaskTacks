<?php


require '../app/helpers/helper.php';


spl_autoload_register(function ($className) {
    if (file_exists('../app/controllers/' . $className . '.controller.php')) {
        require '../app/controllers/' . $className . '.controller.php';
    } elseif (file_exists('../app/models/' . $className . '.php')) {
        require '../app/models/' . $className . '.php';
    }
});



$rutas = [
    '/' => 'Home@show',
];

function router($rutas)
{
    $controllerConseguido = '';
    $VariablesConseguidas = [];

    $userRequest = explode('/', $_SERVER['REQUEST_URI']);
    $sizeRequest = count($userRequest);

    foreach ($rutas as $ruta => $controller) {
        $variablesRequest = [];

        $chopRoute = explode('/', $ruta);

        $sizeChopRoute = count($chopRoute);

        if ($sizeChopRoute==$sizeRequest) {
            $cont = 1;

            for ($i = 1; $i < $sizeRequest; $i++) {
                $miniChop = $chopRoute[$i];

                $subMiniChop = explode(':', $miniChop);

                if ($miniChop==$userRequest[$i]) {
                    $cont++;
                } elseif (count($subMiniChop)==2) {
                    $variablesRequest[$subMiniChop[1]] = $userRequest[$i];
                    $cont++;
                }
            }

            if ($cont==$sizeRequest) {
                $controllerConseguido = $controller;
                $VariablesConseguidas = $variablesRequest;
            }
        }
    }

    return [
        'controller' => $controllerConseguido,
        'args' => $VariablesConseguidas,
    ];
}

$router = router($rutas);




if ($router['controller']) {
    //var_dump($router);
    $getControllerAndMethod = explode('@', $router['controller']);
    $claseInstan = new $getControllerAndMethod[0]();
    $claseInstan->$getControllerAndMethod[1]();
} else {
    echo "No consegui esa vaina mmg.";
}