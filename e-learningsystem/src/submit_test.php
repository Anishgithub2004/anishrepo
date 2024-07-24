<?php
session_start();
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $test_id = $_POST['test_id'];
    $answers = $_POST['answers'];

    try {
        $main_conn->beginTransaction();

        // Insert user responses into user_responses table
        $sql = "INSERT INTO user_responses (user_id, test_id, question_id, selected_option) VALUES (:user_id, :test_id, :question_id, :selected_option)";
        $stmt = $main_conn->prepare($sql);
        foreach ($answers as $question_id => $selected_option) {
            $stmt->execute([
                ':user_id' => $user_id,
                ':test_id' => $test_id,
                ':question_id' => $question_id,
                ':selected_option' => $selected_option
            ]);
        }

        // Calculate the score
        $score = 0;
        $sql = "SELECT * FROM questions WHERE test_id = :test_id";
        $stmt = $main_conn->prepare($sql);
        $stmt->bindParam(':test_id', $test_id);
        $stmt->execute();
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($questions as $question) {
            if ($answers[$question['id']] == $question['correct_option']) {
                $score++;
            }
        }

        $feedback = "Your test score is $score.";
        $sql = "INSERT INTO test_results (user_id, test_id, score, feedback) VALUES (:user_id, :test_id, :score, :feedback)";
        $stmt = $main_conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':test_id', $test_id);
        $stmt->bindParam(':score', $score);
        $stmt->bindParam(':feedback', $feedback);
        $stmt->execute();

        $main_conn->commit();

        echo "Test submitted successfully. Your score: $score";
    } catch (PDOException $e) {
        $main_conn->rollBack();
        echo "Error submitting test: " . $e->getMessage();
        error_log("Error submitting test: " . $e->getMessage(), 3, '../logs/errors.log');
    }

    header("refresh:2;url=../public/my_courses.php");
    exit();
}
?>
