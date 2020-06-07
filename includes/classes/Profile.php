<?php

class Profile {
    private $user;
    private $con;

    public function __construct($con, $user) {
        $this->con = $con;
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user'");
        $this->user = mysqli_fetch_array($user_details_query);
    }

    public function getUsername() {
        return $this->user['username'];
    }

    public function getFirstAndLastName() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['first_name'] . ' ' . ['last_name'];
    }

    public function getHometown() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT hometown FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['hometown'];
    }

    public function getUndergradInstitution() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT undergrad_institution FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['undergrad_institution'];
    }

    public function getUndergradMajor() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT undergrad_major FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['undergrad_major'];
    }

    public function getFunFact() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT fun_fact FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['fun_fact'];
    }

    public function getSocialMedia() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT social_media FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['social_media'];
    }

    public function getResume() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT resume_ FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['resume_'];
    }

    public function getPersonalStatement() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT personal_statement FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['personal_statement'];
    }

    public function getPhoneNumber() {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "SELECT phone_number FROM users WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['phone_number'];
    }
}

?>