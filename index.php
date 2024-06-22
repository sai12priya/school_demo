<?php
include 'db.php';

$stmt = $pdo->prepare('select * from student');
//execute statement
$stmt->execute();

$results = $stmt->fetchAll();

// Fetch all classes from database
$stmtClasses = $pdo->prepare('SELECT * FROM classes');
$stmtClasses->execute();
$classes = $stmtClasses->fetchAll(PDO::FETCH_ASSOC);

// Create an associative array for classes for easy lookup
$classMap = [];
foreach ($classes as $class) {
    $classMap[$class['class_id']] = $class['name'];
}

?>

<!-- index.php -->

<?php
// Include database connection
include 'db.php'; // Assuming db.php contains your PDO connection

// Fetch student records from database
try {
    $sql = "SELECT id, name, email, address, class_id, image FROM student";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching students: " . $e->getMessage();
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
                <div class="flex flex-wrap items-start justify-end -mb-3">

                    <a href="createstudent.php" class="inline-flex px-5 py-3 text-white bg-indigo-500 hover:bg-indigo-600 focus:bg-purple-700 rounded-md ml-6 mb-3">
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="flex-shrink-0 h-6 w-6 text-white -ml-1 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add New Student
                    </a>

                </div>
            </div>
            <section class="grid ">
                <div class="p-6 overflow-scroll px-0">
                    <table class="mt-4 w-full min-w-max table-auto text-left">
                        <thead>
                            <tr>

                                <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                    <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">Student <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                    </p>
                                </th>
                                <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                    <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">Class Name <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                    </p>
                                </th>

                                <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                    <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">Creation Date <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                    </p>
                                </th>
                                <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                    <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">Actions</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $res) : ?>
                                <tr>

                                    <td class="p-4 border-b border-blue-gray-50">
                                        <div class="flex items-center gap-3">
                                            <img src="<?= $res['image'] ?>" alt="picture" class="inline-block relative object-cover object-center !rounded-full w-10 h-10 rounded-md">
                                            <div class="flex flex-col">
                                                <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal"><?= $res['name'] ?></p>
                                                <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal opacity-70"><?= $res['email'] ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-blue-gray-50">
                                        <div class="flex flex-col">
                                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal"><?= $classMap[$res['class_id']] ?></p>
                                        </div>
                                    </td>

                                    <td class="p-4 border-b border-blue-gray-50">
                                        <?php
                                        $created_at = $res['created_at'];
                                        $date = new DateTime($created_at);

                                        // Format the date to 'Y-m-d' which is '2024-06-22'
                                        $formatted_date = $date->format('Y-m-d');
                                        ?>

                                        <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal"><?= $formatted_date ?></p>
                                    </td>
                                    <td class="p-4 border-b flex flex-row border-blue-gray-50">
                                        <div class="flex">


                                            <!-- Button to open modal -->
                                            <button class="text-black block py-1 px-3" onclick="openStudentModal(<?= $res['id'] ?>)"> <!-- Pass the specific student ID here -->
                                                <i class="fas fa-eye fa-lg"></i> <!-- View button -->
                                            </button>

                                            <!-- Modal -->
                                            <div id="studentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
                                                <div class="bg-white shadow-md rounded-lg px-3 py-4 mb-4 w-full max-w-md">
                                                    <div class="block text-gray-700 text-lg font-semibold py-2 px-2">
                                                        Student Details
                                                    </div>
                                                    <div class="flex items-center mb-4">
                                                        <img id="studentImage" src="" alt="Student Image" class="h-16 w-16 rounded-full mr-4">
                                                        <div>
                                                            <div id="studentName" class="font-medium"></div>
                                                            <div id="studentEmail" class="text-sm text-gray-500"></div>
                                                        </div>
                                                    </div>
                                                    <div class="flex mb-2">
                                                        <div class="w-1/3 font-medium text-gray-600">Address:</div>
                                                        <div id="studentAddress" class="w-2/3"></div>
                                                    </div>
                                                    <div class="flex mb-2">
                                                        <div class="w-1/3 font-medium text-gray-600">Class:</div>
                                                        <div id="studentClass" class="w-2/3"></div>
                                                    </div>
                                                    <div class="flex mb-2">
                                                        <div class="w-1/3 font-medium text-gray-600">Creation Date:</div>
                                                        <div id="studentCreationDate" class="w-2/3"></div>
                                                    </div>
                                                    <div class="flex justify-end">
                                                        <button id="cancelButton" class="bg-red-500 rounded-xl text-white font-semibold py-2 px-4">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            function openStudentModal(studentId) {
                                                fetch(`studentdetails.php?id=${studentId}`)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        document.getElementById('studentImage').src = data.image;
                                                        document.getElementById('studentName').textContent = data.name;
                                                        document.getElementById('studentEmail').textContent = data.email;
                                                        document.getElementById('studentAddress').textContent = data.address;
                                                        document.getElementById('studentClass').textContent = data.class;
                                                        document.getElementById('studentCreationDate').textContent = data.created_at;
                                                        document.getElementById('studentModal').classList.remove('hidden');
                                                    })
                                                    .catch(error => console.error('Error fetching student data:', error));
                                            }

                                            document.getElementById('cancelButton').addEventListener('click', () => {
                                                document.getElementById('studentModal').classList.add('hidden');
                                            });
                                        </script>


                                        <a href="editstudent.php?id=<?= $res['id'] ?>" class="text-black block py-1 -mr-4  px-6" onclick="openDropdown(event,'table-dark-1-dropdown')">
                                            <i class="fas fa-edit fa-lg"></i>
                                        </a>
                                        <form action="deletestudent.php" method="POST">
                                            <input type="hidden" name="_method" value="delete">
                                            <input type="hidden" name="id" value="<?= $res['id'] ?>">
                                            <button name="submit" type="submit" class="text-black block py-1 px-6 -mr-4" onclick="openDropdown(event,'table-dark-1-dropdown')">
                                                <i class="fas fa-trash-alt fa-lg"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                    <!-- Modal -->


                </div>
            </section>

        </main>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function openModal(studentId) {
            fetch('studentdetails.php?id=' + studentId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('studentImage').src = data.image;
                    document.getElementById('studentName').textContent = data.name;
                    document.getElementById('studentEmail').textContent = data.email;
                    document.getElementById('studentAddress').textContent = data.address;
                    document.getElementById('studentClass').textContent = data.class;
                    document.getElementById('studentCreationDate').textContent = data.creation_date;

                    document.getElementById('studentModal').classList.remove('hidden');
                })
                .catch(error => console.error('Error fetching student details:', error));
        }

        document.getElementById('cancelButton').addEventListener('click', function() {
            document.getElementById('studentModal').classList.add('hidden');
        });

        document.querySelectorAll('.view-button').forEach(button => {
            button.addEventListener('click', function() {
                const studentId = this.getAttribute('data-student-id');
                openModal(studentId);
            });
        });
    });
</script>




</html>