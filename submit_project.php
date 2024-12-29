<?php
include('config.php'); // تضمين ملف الاتصال بقاعدة البيانات

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // الحصول على القيم من النموذج
    $projectType = $_POST['type'] ?? '';
    $projectName = $_POST['name'] ?? '';
    $projectAddress = $_POST['address'] ?? '';
    $projectDescription = $_POST['description'] ?? '';
    $website = $_POST['website'] ?? '';
    $twitter = $_POST['twitter'] ?? '';
    $email = $_POST['email'] ?? '';
    $startDate = $_POST['start'] ?? '';
    $endDate = $_POST['end'] ?? '';

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
            exit; // إيقاف التنفيذ إذا فشل رفع الصورة
        }
    }

    // تاريخ ووقت الإدخال
    $createdAt = date('Y-m-d H:i:s');

    // استعلام SQL لإدخال بيانات المشروع الجديد
    $sql_insert = "INSERT INTO `project_form` (`created_at`, `type`, `name`, `address`, `description`, `website`, `twitter`, `email`, `start`, `end`, `logo`) VALUES ('$createdAt', '$projectType', '$projectName', '$projectAddress', '$projectDescription', '$website', '$twitter', '$email', '$startDate', '$endDate', '$logo')";
    
    $result_insert = mysqli_query($con, $sql_insert);

    if ($result_insert) {
        echo '<div class="alert alert-success" role="alert">تمت إضافة المشروع بنجاح!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">حدث خطأ أثناء إضافة المشروع.</div>';
    }
}
?>
