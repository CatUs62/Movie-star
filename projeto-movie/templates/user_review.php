<?php

require_once("models/User.php");

$userModel = new User();

$fullName = $userModel->getFullName($review->user);

if ($review->user->image == "") {
    $review->user->image = "profile.png";
}

?>

<div class="review">
    <div id="row">
        <div>
            <div class="profile-image-container review-image" style="background-image: url(<?= $BASE_URL ?>/assets/users/<?= $review->user->image ?>);"></div>
            <div class="author-details-container">
                <h4 class="author-name"><a href="<?= $BASE_URL ?>profile.php"><?= $fullName ?></a></h4>
                <p><i class="fas fa-star"></i><?= $review->rating ?></p>
            </div>
            <div>
                <p class="comment-title">Comment:</p>
                <p><?= $review->review ?></p>
            </div>
        </div>
    </div>
</div>