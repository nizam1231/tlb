<?php
include('config.php'); // تضمين ملف الاتصال بقاعدة البيانات

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $projectType = $_POST['projectType'];
    $projectName = $_POST['projectName'];
    $projectAddress = $_POST['projectAddress'];
    $projectDescription = $_POST['projectDescription'];
    $website = $_POST['website'];
    $twitter = $_POST['twitter'];
    $email = $_POST['email'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // معالجة تحميل الشعار
    $logo = 'uploads/placeholder.jpg'; // المسار المؤقت للشعار
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == UPLOAD_ERR_OK) {
        $logo_tmp_name = $_FILES['logo']['tmp_name'];
        $logo_name = basename($_FILES['logo']['name']);
        $logo_path = 'uploads/' . $logo_name;

        // نقل الشعار إلى المجلد المؤقت على الخادم
        if (move_uploaded_file($logo_tmp_name, $logo_path)) {
            $logo = $logo_path; // حفظ المسار في قاعدة البيانات
        } else {
            echo '<div class="alert alert-danger" role="alert">خطأ أثناء رفع الشعار.</div>';
        }
    }

    // استعلام SQL لإدخال بيانات المشروع الجديد
    $sql_insert = "INSERT INTO project_form (project_type, `project name`, address, `project description`, website, twitter, email, `star date`, `end date`, `project logo`) VALUES ('$projectType', '$projectName', '$projectAddress', '$projectDescription', '$website', '$twitter', '$email', '$startDate', '$endDate', '$logo')";
    $result_insert = mysqli_query($con, $sql_insert);

    if ($result_insert) {
        echo '<div class="alert alert-success" role="alert">تمت إضافة المشروع بنجاح!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">حدث خطأ أثناء إضافة المشروع.</div>';
    }
}
?>
