<?php
// Include database connection
include 'db.php'; // Assuming db.php contains your PDO connection

// Define variables and initialize with empty values
$name = $email = $address = $class_id = "";
$name_err = $email_err = $address_err = $class_err = $image_err = "";

// Fetch classes from database
try {
    $sql = "SELECT class_id, name FROM classes";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching classes: " . $e->getMessage();
}

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $name_err = "Name is required";
    } else {
        $name = $_POST["name"];
    }

    // Validate email
    if (empty($_POST["email"])) {
        $email_err = "Email is required";
    } else {
        $email = $_POST["email"];
    }

    // Validate address
    if (empty($_POST["address"])) {
        $address_err = "Address is required";
    } else {
        $address = $_POST["address"];
    }

    // Validate class_id
    if (empty($_POST["class_id"])) {
        $class_err = "Class is required";
    } else {
        // Cast the value to integer
        $class_id = (int)$_POST["class_id"];
    }

    // Check if image file is selected
    if ($_FILES["image"]["error"] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $image_err = "File is not an image.";
        }

        // Allow only certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png") {
            $image_err = "Sorry, only JPG, PNG files are allowed.";
        }

        // If no errors, upload the file
        if (empty($image_err)) {
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_err = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $image_err = "Image file is required";
    }

    // If there are no errors, insert into database using PDO
    if (empty($name_err) && empty($email_err) && empty($address_err) && empty($class_err) && empty($image_err)) {
        try {
            // Prepare SQL statement to insert data into database
            $sql = "INSERT INTO student (name, email, address, class_id, image) VALUES (:name, :email, :address, :class_id, :image)";
            $stmt = $pdo->prepare($sql);

            // Bind parameters to statement
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':class_id', $class_id, PDO::PARAM_INT); // Explicitly bind as integer
            $stmt->bindParam(':image', $target_file);

            // Execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to home page after successful insertion
                header("location: index.php");
                exit();
            } else {
                echo "Error executing the SQL statement: " . $stmt->errorInfo();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // Close connection
    unset($pdo);
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
            <div class="max-w-md w-full mx-auto mt-8 space-y-8 p-10 bg-white rounded-xl shadow-lg z-10">
                <div class="grid  gap-8 grid-cols-1 ">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="flex flex-col">
                            <div class="flex flex-col sm:flex-row items-center">
                                <h2 class="font-semibold text-lg mr-auto">Student Info</h2>
                                <div class="w-full sm:w-auto sm:ml-auto mt-3 sm:mt-0"></div>
                            </div>
                            <div class="mt-5">
                                <div class="form space-y-2">
                                    <div class="relative z-0 w-full mb-5">
                                        <label for="name" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-gray-600">Enter name</label>
                                        <input type="text" name="name" id="name" placeholder="Enter student's name" required class="flex h-10 w-full rounded-md border border-gray-200 bg-transparent px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
                                        <span class="text-sm text-red-600"><?php echo $name_err; ?></span>
                                    </div>

                                    <div class="relative z-0 w-full mb-5">
                                        <label for="email" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-gray-600">Enter email address</label>
                                        <input type="email" name="email" id="email" placeholder="Enter student's email" required class="flex h-10 w-full rounded-md border border-gray-200 bg-transparent px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                                        <span class="text-sm text-red-600"><?php echo $email_err; ?></span>
                                    </div>

                                    <div class="relative z-0 w-full mb-5">
                                        <label for="address" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-gray-600">Enter address</label>
                                        <input type="text" name="address" id="address" placeholder="Enter student's address" required class="flex h-10 w-full rounded-md border border-gray-200 bg-transparent px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" value="<?php echo isset($address) ? htmlspecialchars($address) : ''; ?>">
                                        <span class="text-sm text-red-600"><?php echo $address_err; ?></span>
                                    </div>

                                    <div class="relative z-0 w-full mb-5">
                                        <label for="class_id" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-gray-600">Select class</label>
                                        <select name="class_id" id="class_id" class="flex h-10 w-full rounded-md border border-gray-200 bg-transparent px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                                            <option value="" selected disabled hidden>Select class</option>
                                            <?php foreach ($classes as $classItem) : ?>
                                                <option value="<?php echo $classItem['class_id']; ?>" <?php echo ($class_id == $classItem['class_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($classItem['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="text-sm text-red-600"><?php echo $class_err; ?></span>
                                    </div>

                                    <div class="relative z-0 w-full mb-5">
                                        <label for="image" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-gray-600">Company Logo<abbr class="hidden" title="required">*</abbr></label>
                                        <div class="flex items-center py-6">
                                            <label for="image" class="cursor-pointer">
                                                <span class="focus:outline-none text-white text-sm py-2 px-4 rounded-full bg-green-400 hover:bg-green-500 hover:shadow-lg">Browse</span>
                                                <input type="file" name="image" id="image" class="hidden" accept=".jpg, .png" required>
                                            </label>
                                            <span class="text-sm text-red-600 ml-2"><?php echo $image_err; ?></span>
                                        </div>
                                    </div>

                                    <button id="button" name="submit" type="submit" class="w-full px-6 py-3 mt-3 text-lg text-white transition-all duration-150 ease-linear rounded-lg shadow outline-none bg-indigo-500 hover:bg-indigo-600 hover:shadow-lg focus:outline-none">
                                        Submit
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>



</body>


</html>