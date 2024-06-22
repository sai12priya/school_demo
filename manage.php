<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' and isset($_POST['submit'])) {

    // Retrieve form data


    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : "";



    // Insert job details into the database
    $sql = 'INSERT INTO classes ( name) 
            VALUES (:name)';
    $stmt = $pdo->prepare($sql);

    $params = [

        'name' => $name
    ];

    if ($stmt->execute($params)) {
        header('location: manage.php');
    } else {
        echo "There was an error creating class";
    }
}
?>

<?php

include 'db.php';


//prepare select statement
$stmt = $pdo->prepare('select * from classes');
//execute statement
$stmt->execute();

//fetch results

//$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$results = $stmt->fetchAll();
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
    <style>
        #form-container {
            display: none;
        }
    </style>
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
                            <div class="py-8 text-base leading-6 space-y-4 w-full text-gray-700 sm:text-lg sm:leading-7">
                                <div class="relative pt-2 w-full">
                                    <label for="name" class="text-base project-lead font-bold leading-7 text-gray-700">Class Name</label>
                                    <select name="name" id="name" class="w-full px-4 py-2 pr-4 mt-2 text-base text-blueGray-500 transition duration-500 ease-in-out transform rounded-lg bg-gray-200 focus:border-gray-300 focus:bg-gray-200 focus:outline-none focus:shadow-outline focus:ring-1">
                                        <?php
                                        for ($i = 1; $i <= 10; $i++) {
                                            echo "<option>Class $i</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="pt-4 flex items-center space-x-4">
                                <button id="cancel-button" class="bg-indigo-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none">Cancel</button>
                                <button name="submit" type="submit" class="bg-indigo-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none">Create</button>
                            </div>
                        </form>
                    </div>




                    <div class="flex items-center justify-center">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                            <!-- 1 card -->


                            <?php foreach ($results as $res) : ?>
                                <div class="relative bg-blue-50 py-6 pl-6 rounded-3xl w-80 my-4 shadow-xl">
                                    <div class="text-white flex items-center absolute rounded-full py-4 px-4 shadow-xl bg-gray-500 left-4 -top-6">
                                        <!-- svg  -->
                                        <i class="fa fa-university h-4" aria-hidden="true"></i>
                                    </div>

                                    <div class="mt-8">
                                        <p class="text-xl font-semibold my-2"><?= $res['name'] ?></p>
                                        <div class="flex space-x-2 text-gray-400 text-md">
                                            <!-- svg  -->
                                            <img width="20" height="24" src="https://img.icons8.com/forma-thin/24/identification-documents.png" alt="identification-documents" />
                                            <p class="pt-1 pl-1 text-gray-500"><span class="text-gray-700 pl-1 font-bold">Class ID : </span><?= $res['class_id'] ?></p>
                                        </div>
                                        <div class="flex space-x-2 text-gray-400 text-md">
                                            <!-- svg  -->
                                            <?php
                                            $created_at = $res['created_at'];
                                            $date = new DateTime($created_at);

                                            // Format the date to 'Y-m-d' which is '2024-06-22'
                                            $formatted_date = $date->format('Y-m-d');
                                            ?>

                                            <i class="fa fa-calendar-o fa-md pl-0.5 pt-2 text-black" aria-hidden="true"></i>
                                            <p class="pt-1 pl-1 text-gray-500"><span class="text-gray-700 pl-2 font-bold">Created Date : </span><?= $formatted_date ?></p>
                                        </div>




                                        <!-- Buttons -->
                                        <div class="flex justify-between mt-4">
                                            <!-- update button -->
                                            <a href="editclass.php?id=<?= $res['class_id'] ?>">
                                                <button class="mr-4 ml-6 relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs bg-blue-500 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none" type="button">
                                                    <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                                        <i class="fas fa-edit" aria-hidden="true"></i>
                                                    </span>
                                                </button>
                                            </a>



                                            <form action="deleteclass.php" method="POST">
                                                <input type="hidden" name="_method" value="delete">
                                                <input type="hidden" name="class_id" value="<?= $res['class_id'] ?>"> <!-- Set the actual class ID here -->
                                                <button name="submit" type="submit" class="mr-16 relative align-middle select-none font-sans font-medium text-center uppercase transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none w-10 max-w-[40px] h-10 max-h-[40px] rounded-lg text-xs bg-red-500 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none">
                                                    <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                                    </span>
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>



                </section>

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