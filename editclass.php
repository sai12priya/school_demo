<?php
require 'db.php';

// Get id from query string
$class_id = $_GET['id'] ?? null;

// If id is null, redirect to index.php
if (!$class_id) {
    header('Location: manage.php');
    exit;
}

// SELECT statement with placeholder for id
$sql = 'SELECT * FROM classes WHERE class_id = :class_id';

// Prepare the SELECT statement
$stmt = $pdo->prepare($sql);

// Params for prepared statement
$params = ['class_id' => $class_id];

// Execute the statement
$stmt->execute($params);

// Fetch the post from the database
$result = $stmt->fetch();

//check form submit
$isput = $_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['_method'] ?? '') === 'put';

if ($isput) {


    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : "";


    $sql = 'update classes set name=:name
    

    where class_id = :class_id';

    $stmt = $pdo->prepare($sql);

    $params = [
        'class_id' => $class_id,
        'name' => $name
    ];

    $stmt->execute($params);

    header('Location: manage.php');

    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/logo.jpeg" />
    <link rel="icon" type="image/png" href="../assets/img/logo.jpeg" />
    <title>Tasks</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Main Styling -->
    <link href="../assets/css/argon-dashboard-tailwind.css?v=1.0.1" rel="stylesheet" />


    <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <script src="https://cdn.tailwindcss.com/3.3.0"></script>
    <script>
        tailwind.config = {
            darkMode: "class",

            corePlugins: {
                preflight: false,
            },
        };
    </script>

</head>

<body class="flex bg-gray-100 min-h-screen">
    <aside class="hidden sm:flex sm:flex-col">

        <div class="flex-grow flex flex-col justify-between text-gray-500 bg-gray-800">
            <nav class="flex flex-col mx-4 my-6 space-y-4">
                <a href="index.php" class="inline-flex items-center justify-center p-2 py-3 text-purple-600 bg-white rounded-lg">

                    <img width="25" height="25" src="https://img.icons8.com/external-inkubators-basic-outline-inkubators/32/external-dashboards-dashboard-ui-inkubators-basic-outline-inkubators.png" alt="external-dashboards-dashboard-ui-inkubators-basic-outline-inkubators" />
                    <p class="text-black pt-1 pl-2 pr-2">Home</p>
                </a>
                <a href="manage.php" class="inline-flex items-center justify-center p-2 py-3 text-purple-600 bg-white rounded-lg">


                    <img width="25" height="25" src="https://img.icons8.com/ios/50/city-buildings.png" alt="city-buildings" />
                    <p class="text-black pt-1 pl-2 pr-2">Classes</p>
                </a>

            </nav>

        </div>
    </aside>
    <div class="flex-grow text-gray-800">
        <header class="flex items-center h-20 px-6 sm:px-10 bg-white">
            <button id="menuButton" class="block sm:hidden relative flex-shrink-0 p-2 mr-2 text-gray-600 hover:bg-gray-100 hover:text-gray-800 focus:bg-gray-100 focus:text-gray-800 rounded-full">
                <span class="sr-only">Menu</span>
                <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>

            <script>
                const menuButton = document.getElementById('menuButton');
                const navbar = document.querySelector('aside');

                menuButton.addEventListener('click', function() {
                    navbar.classList.toggle('hidden');
                });
            </script>


        </header>
        <main class=" sm:p-10 space-y-6">
            <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
                <div class="mr-6">
                    <h1 class="text-4xl font-semibold mb-2">School Management</h1>
                    <h2 class="text-gray-600 ml-0.5">Classes and Students</h2>
                </div>

            </div>



            <div class="flex-grow text-gray-800">
                <div class="flex flex-row items-center mt-6 justify-center">
                    <button id="add-class" class="inline-block rounded bg-indigo-500 px-6 mb-4 mr-4 pb-2 pt-2.5 text-md font-semibold uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-indigo-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-indigo-400 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">Add Class</button>
                </div>



                <section class="grid pt-4">

                    <div id="form-container" class="divide-y w-1/3 mx-auto shadow-xl p-6 rounded-lg divide-gray-200 bg-white">

                        <form method="post">
                            <input type="hidden" name="_method" value="put">
                            <div class="py-8 text-base leading-6 space-y-4 w-full text-gray-700 sm:text-lg sm:leading-7">
                                <div class="relative pt-2 w-full">
                                    <label for="name" class="text-base project-lead font-bold leading-7 text-gray-700">Class Name</label>
                                    <select name="name" id="name" class="w-full px-4 py-2 pr-4 mt-2 text-base text-blueGray-500 transition duration-500 ease-in-out transform rounded-lg bg-gray-200 focus:border-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline focus:ring-1">
                                        <?php
                                        for ($i = 1; $i <= 10; $i++) {
                                            $selected = ($result['name'] == "Class $i") ? 'selected' : '';
                                            echo "<option value=\"Class $i\" $selected>Class $i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="pt-4 flex items-center space-x-4">
                                <button type="button" id="cancel-button" class="bg-indigo-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none" onclick="window.location.href='manage.php';">Cancel</button>
                                <button name="submit" type="submit" class="bg-indigo-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none">Create</button>
                            </div>
                        </form>
                    </div>


                </section>

            </div>
        </main>
    </div>
</body>
<script>
    document.getElementById('add-class').addEventListener('click', function() {
        document.getElementById('form-container').style.display = 'block';
    });

    document.getElementById('cancel-button').addEventListener('click', function() {
        document.getElementById('form-container').style.display = 'none';
    });
</script>

</html>