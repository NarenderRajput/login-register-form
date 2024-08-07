<?php
$asset = "../";
$controller_path = "../../";
$view_path = "../";

include "../../config/app.php";
include "../../helper/common.php";
include "../../config/db.php";
include "../layouts/d_header.php";

$user_id = $_SESSION["users"]["id"];
$members = [];


function get_members($conn, $user_id)
{
    $mabr = [];
    $sql = "SELECT * FROM users WHERE parent_id =" . $user_id;

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $mabr[] = $row;
        }
    }
    return $mabr;
}

$members = get_members($conn, $user_id);


$errors = isset($_SESSION["errors"]) ? $_SESSION["errors"] : [];

?>

<div class="w-100">

    <div class="d-flex h-full bg-danger-subtle ">
        <?php
        include "../layouts/side_nav.php";
        ?>
        <div class=" card w-100   ">

            <?php
            include "../layouts/top_nav.php";
            ?>
            <div class="m-3 p-3">
                <h2>Create Task</h2>
                <form action="../../controller/SaveTaskController.php" method="POST" enctype="multipart/form-data">

                    <input type="text" name="name" placeholder="Title" class="form-control w-50 mb-2 mt-2"> <br>
                    <?php
                    if (isset($errors["nameErr"])) { ?>
                        <p class="text-danger"><?php echo $errors["nameErr"] ?></p>
                    <?php  } ?>

                    <textarea name="discription" placeholder="Discription" id="" class="form-control w-50 mb-2 mt-2"></textarea>
                    <?php
                    if (isset($errors["discriptionErr"])) { ?>
                        <p class="text-danger"><?php echo $errors["discriptionErr"] ?></p>
                    <?php } ?>

                    <select name="member_id" class="form-control w-50 mb-2 mt-2">
                        <?php
                        foreach ($members as $member) { ?>
                            <option value="<?php echo $member["id"] ?>"><?php echo $member["firstname"] ?></option>
                        <?php } ?>
                    </select> <br>

                    <?php
                    if (isset($errors["member_idErr"])) { ?>
                        <p class="text-danger"><?php echo $errors["member_idErr"] ?></p>
                    <?php } ?>

                    <select name="status" class="form-control w-50 mb-2 mt-2">
                        <option value="pending">Panding</option>
                        <option value="processing">Processing</option>
                        <option value="complete">Complete</option>
                    </select> <br>

                    <?php
                    if (isset($errors["statusErr"])) { ?>
                        <p class="text-danger"><?php echo $errors["statusErr"] ?></p>
                    <?php } ?>


                    <button type="submit" class="mt-2 p-2 ps-4 pe-4 btn btn-primary" class="w-75">Submit</button>


                </form>
            </div>
        </div>
    </div>
</div>



<?php
include "../layouts/d_footer.php";
?>