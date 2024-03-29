<?php

    require "comun_db.php";

    if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath("comun_html.php") == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
        
        header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
        
        $url = 'https://void.ugr.es/~ftm19971718/proyecto/index.php';
        
        die( header('Location: '.$url) );
    }

    function select_fechatarjeta(){
        echo <<<HTML
                    <span><label>Fecha de caducidad y código de seguridad: 
HTML;
                    echo <<<HTML
                                <select name="mestarjeta">
                                    <option value="" selected>--</option>
HTML;
                                for($i = 1; $i <= 12; $i++)
                                    echo '<option value="',$i,'">',$i,'</option>';

                    echo <<<HTML
                                    </select> / 
HTML;
                    echo <<<HTML
                                <select name="aniotarjeta">
                                    <option value="" selected>----</option>
HTML;
                                for($i = 2018; $i <= 2029; $i++)
                                    echo '<option value="',$i,'">',$i,'</option>';

                    echo <<<HTML
                                </select></label></span>
HTML;
    }

    // Encabezado de los HTMLs
    function Encabezado($value){
        if(!isset($_COOKIE['logged-in'])){
            $items = ["Home", "Biografía", "Discografía", "Conciertos", "Register", "Login"];
            $links = ["index.php?id=0", "index.php?id=1", "index.php?id=2", "index.php?id=3", "index.php?id=4", "index.php?id=5"];
        }else{
            if($_COOKIE['logged-in']){
                $items = ["Home", "Biografía", "Discografía", "Conciertos", "Logout", $_SESSION['id']];
                $links = ["index.php?id=0", "index.php?id=1", "index.php?id=2", "index.php?id=3","index.php?id=logout", "index.php?id=5"];
            }
        }
        echo <<<HTML
                        <!DOCTYPE html>
                        <!-- Ejemplo de página web -->
                        <html lang="es">   
                            <head>
HTML;
                                //Selecciono el titulo
                                echo "<title>Daft Punk | ".$items[$value]."</title>";
echo <<< HTML
                                <meta charset="utf-8">
                                <meta name="author" content="Fernando Talavera Mendoza">
                                <meta name="keywords" content="tecnologías web, html, programación">
                                <link rel="shortcut icon" href="./img/favicon.png" type="image/png">
                                <link rel="stylesheet" href="./style.css">
                            </head>
                            
                            <body class="grid">
                                <header class="header-grid">
                                    <img src="./img/logo-image-file.png" alt="Logo Imagen"/>
                                </header>
                                <nav class="nav-grid">
                                    <ul>
HTML;
                        // Genero el nav y activo el <a>
                        foreach ($items as $k => $v){
                            if($k == 4 || $k == 5)
                                echo '<li id="right"'.($k==$value?" class='active'":"").">"."<a href='".$links[$k]."'>".$v."</a></li>";
                            else
                                echo "<li".($k==$value?" class='active'":"").">"."<a href='".$links[$k]."'>".$v."</a></li>";
                        }
        echo <<<HTML
                                    </ul>
                                </nav>
HTML;
    }

    // Aside 
    function Aside($db){
        $consulta = "SELECT DISTINCT ciudad FROM concierto;";
        $resultado = mysqli_query($db,$consulta);

        echo <<<HTML
            <aside class="aside-grid">
HTML;
            if(isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1){
            echo <<<HTML
                <form action="editar.php" method="POST">
                    <span><input type="submit" name="editar_componentes" value="Componentes"/></span>
                    <span><input type="submit" name="editar_biografia" value="Biografía"/></span>
                    <span><input type="submit" name="editar_discografia" value="Discografía"/></span>
                    <span><input type="submit" name="editar_concierto" value="Conciertos"/></span>
                </form>
HTML;
        }
        echo <<<HTML
                <span><form action="busqueda.php" method="POST">
                    <span><label>Buscar un disco o una canción <input type="text" name="search" placeholder="Buscar..."/></label></span>
                    <span><label> Introducir dos fechas: <input type="text" name="fecha_iniciocancion" placeholder="Fecha de inicio"/> <input type="text" name="fecha_fincancion" placeholder="Fecha de final"/></label></span> 
                    <span><input type="submit" name="discografia_searchbutton" value="Buscar"/></span>
                </form></span>
                
                <span><form action="busqueda.php" method="POST">
                    <span><label> Selecciona una concierto:
                    <select name="conciertos_search" multiple>
HTML;
                    while($fila = mysqli_fetch_row($resultado)){
                            echo "<option>", $fila['0'], "</option>";
                    }
        echo <<<HTML
                    </select></label></span>
                    <span><label> Introducir dos fechas: <input type="text" name="fecha_iniciogira" placeholder="Fecha de inicio"/> <input type="text" name="fecha_fingira" placeholder="Fecha de final"/></label></span> 
                    <span><input type="submit" name="conciertos_searchbutton" value="Buscar"/></span>
                </form></span>
            </aside>
HTML;
    }

    // El contenido del main de cada página
    function Content($db,$value){
        switch($value){
            // Home
            case 0:
                $consulta = "SELECT * FROM componentes;";
                $resultado = mysqli_query($db,$consulta);

                echo <<<HTML
                    <main class="main-grid">
                        <article>
                            <h1> Home </h1>
                            <span><p> 
                                Daft Punk es un dúo de productores formado por los músicos franceses Guy-Manuel 
                                de Homem-Christo (n. 1974) y Thomas Bangalter (n. 1975). Daft Punk alcanzó 
                                una gran popularidad en el estilo house a finales de la década de los 90 en Francia 
                                y continuó con su éxito los años siguientes, usando el estilo synthpop. El dúo 
                                también es acreditado por la producción de canciones que se consideran esenciales en 
                                el estilo french house. 
                            </p></span>

                            <img id="main" src="./img/img2" alt="Cascos"/>

                            <span><p> 
                                El acrónimo "Daft", presente en su primer DVD, proviene de las iniciales de "A Story 
                                about Dogs, Androids, Firemen and Tomatoes". Estas palabras reciben significado al dúo 
                                musical por su primera canción «Da Funk» del año 1995 perteneciente al álbum Homework, 
                                dónde aparece un perro antropomorfo como protagonista en el vídeo. Luego "Androids" por 
                                la aparición de robots bailando en el vídeo «Around the World» del año 1997 del álbum 
                                Homework. "Fireman" (Bomberos en español) que aparecen en el video de «Burnin'» y "Tomatoes" 
                                por el vídeo «Revolution 909».
                            </p></span>

                            <span><p> 
                                A principios de la carrera del grupo, los miembros de la banda estaban influidos por bandas 
                                como The Beach Boys y The Rolling Stones. Bangalter y de Homem-Christo se encontraban originalmente 
                                en una banda llamada Darlin', que se disolvió después de un corto periodo de tiempo, permitiendo 
                                a los dos experimentar con música por su cuenta. El dúo se convirtió en Daft Punk, y lanzaron su 
                                aclamado álbum debut Homework en 1997. El segundo álbum, Discovery, lanzado en 2001, fue aún más 
                                exitoso, impulsado por los sencillos «One More Time», «Digital Love» y «Harder, Better, Faster, 
                                Stronger». En marzo de 2005, el dúo lanzó el álbum Human After All, recibiendo críticas mixtas. 
                                Sin embargo, «Robot Rock» y «Technologic» tuvieron éxito en el Reino Unido. Daft Punk hizo una gira 
                                a lo largo de 2006 y 2007 y lanzó su álbum en vivo Alive 2007, el cual ganó un Grammy al Mejor 
                                Álbum de Electrónica/Dance. El dúo compuso la música para la película Tron: Legacy y en 2010 lanzó 
                                el álbum de la banda sonora de la película.
                            </p></span>

                            <img id="main" src="./img/img1" alt="Daft Punk con Giorgio Moroder"/>

                            <span><p> 
                                Daft Punk es conocido por sus elaborados conciertos en los que incorporan efectos visuales, por el 
                                énfasis que ponen en la historia y los componentes visuales de sus producciones musicales. También 
                                porque desde 2001 en sus actuaciones o apariciones públicas aparecen disfrazados de robot. En muy 
                                raras ocasiones conceden entrevistas o aparecen en televisión.
                            </p></span>

                            <span><p> 
                                El dúo ha vendido más de 12 millones de álbumes, y más de 17 millones de sencillos.
                            </p></span>
                        </article>

                        <article>
                            <h1> Componentes </h1>
HTML;
                            while($fila = mysqli_fetch_row($resultado)){
                                $fecha = date("Y-m-d", strtotime($fila['1']));
                                echo '<span><section class="componentefoto">';
                                echo '<img src="./imagenes/'.$fila['3'].'"/></section></span>';
                                echo '<span><h1>'.$fila['0']."</h1></span>";
                                echo "<span><p>".$fecha."  ".$fila['2']."</p></span>";
                                echo "<span><p>".$fila['4']."</p></span>";
                                echo "</section></span>";
                            }
            echo <<<HTML
                            
                        </article>
                    </main>
HTML;
            break;

            // Biografía
            case 1:
                $consulta = "SELECT * FROM biografia;";
                $resultado = mysqli_query($db,$consulta);

                echo <<<HTML
                    <main class="main-grid">
                        <article>
                            <h1>Biografía</h1>
HTML;
                            while($fila = mysqli_fetch_row($resultado)){
                                echo "<span><section><h1>".$fila['1']."</h1>";
                                echo "<span>".$fila['3']."</span>";
                                if(!is_null($fila['2']))
                                    echo '<span><img id="main" src="./imagenes/'.$fila['2'].'"/></span>';
                                echo "</section></span>";
                            }
            echo <<<HTML
                        </article>
                    </main> 
HTML;
            break;

            // Discografía
            case 2:
                echo <<<HTML
                    <main class="main-grid">
HTML;
                        if(isset($_GET['disco'])){
                            echo "<article>";
                                BD_ListarCanciones($db,$_GET['disco'],null);
                            echo "</article>";
                echo <<<HTML
                            <article>
                                <form action="comprar.php" method="POST">
                                    <span><label>Nombre: <input type="text" name="nombre"/></label></span>
                                    <span><label>Apellidos: <input type="text" name="apellidos"/></label></span>
                                    <span><label>Correo electrónico: <input type="email" name="email"/></label></span>
                                    <span><label>Telefono: <input type="number" name="telefono"/></label></span>
                                    <span><label>Dirección de envio: <input type="text" name="direccion"/></label></span>
                                    <span><label><input type="radio" name="metodopago" value="tarjetadecredito"/> Tarjeta de crédito </label></span>
                                    <span><label><input type="radio" name="metodopago" value="contrareembolso"/> Contra-reembolso </label></span>
                                    <span><label>Número de tarjeta: <input type="number" name="numtarjeta"/></label></span>
HTML;
                                    select_fechatarjeta();
                echo <<<HTML
                                    <span><label>cvc: <input type="number" name="cvc"/></label></span>
                                    <span><input type="submit" name="comprar" value="Comprar"/></span>
                                </form>
                            </article>
HTML;
                        }else{
                            $consulta = "SELECT * FROM album;";
                            echo "<article>";
                                BD_ListarAlbum($db, $consulta);
                            echo "</article>";
                        }
            echo <<<HTML
                    </main>
HTML;
            break;

            // Conciertos
            case 3:
                echo <<<HTML
                    <main class="main-grid">
                        <article>
HTML;
                            $consulta = "SELECT * FROM concierto;";
                            // Listamos los conciertos de la Base de datos
                            BD_ListarConciertos($db,$consulta);
            echo <<<HTML
                        </article>
                    </main> 
HTML;
            break;

            // Registro de usuario
            case 4:
                echo <<<HTML
                    <main class="main-grid">
                        <article>
                            <h1>Register</h1>

                            <form action="register.php" method="POST">
                                <span><label>Id de usuario: <input type="text" name="id"/></label></span>
                                <span><label>Contraseña: <input type="password" name="password"/></label></span>
                                <span><label>Nombre: <input type="text" name="nombre"/></label></span>
                                <span><label>Apellidos: <input type="text" name="apellido"/></label></span> 
                                <span><label>Email: <input type="email" name="email"/></label></span> 
                                <span><label>Teléfono: <input type="number" name="tlf"/></label></span>
                                <span><label>Tipo de usuario: 
                                <select name="tipo">
                                    <option value="1" selected>Administrador</option>
                                    <option value="2">Gestor de compras</option>
                                </select></label></span>
                                <span><input type="submit" name="signup" value="Sign up"/></span>
                            </form>
                        </article>
                    </main>
HTML;
            break;

            // Login
            case 5:
                if(isset($_SESSION['id']) && isset($_SESSION['tipo']) && $_SESSION['tipo'] == 1){
                    echo <<<HTML
                        <main class="main-grid">
                                <article>
HTML;
                                    echo "<h1>".$_SESSION['id']."</h1>";
                    echo<<<HTML
                                    <form action="editar.php" method="POST">
                                        <span><input type="submit" name="editar_usuario" value="Editar usuario"/></span>
                                    </form>

                                    <form action="visualizar.php" method="POST">
                                        <span><input type="submit" name="visualizar" value="Visualizar eventos"/></span>
                                    </form>
HTML;
                                    BD_ListarUsuarios($db);
                    echo <<<HTML
                                </article>
                            </main>
HTML;
                }else if(isset($_SESSION['id']) && isset($_SESSION['tipo']) && $_SESSION['tipo'] == 2){
                    echo <<<HTML
                        <main class="main-grid">
                                    <article>
HTML;
                                        echo "<h1>".$_SESSION['id']."</h1>";
                                        BD_ListarPedidos($db);

                        echo <<<HTML
                                    </article>
                                </main>
HTML;
                }else{
                    echo <<<HTML
                    <main class="main-grid">
                        <article>
                            <h1>Login</h1>

                            <form action="login.php" method="POST">
                                <span><label>Id de usuario: <input type="text" name="id"/></label></span>
                                <span><label>Contraseña: <input type="password" name="password"/></label></span>
                                <span><input type="submit" name="login" value="Login"/></span>
                            </form>

                        </article>
                    </main>
HTML;
                }
            break;
        }
    }

    // Footer
    function Footer(){
        echo <<<HTML
                            <footer class="footer-grid">
                                <ul>
                                    <li><a>© 2018 Copyright</a></li>
                                    <li><a>Designed by Thejoker</a></li>
                                </ul>
                            </footer>
                        </body>
                    </html>
HTML;
    }
?>