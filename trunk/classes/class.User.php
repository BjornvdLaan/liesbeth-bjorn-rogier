<?php

class User implements DbComm {

    protected $id;
    protected $username;
    protected $password;
    protected $gender;
    protected $email;
    protected $location;
    protected $birthday;
    protected $facebookId = NULL;
    protected $authToken;

    protected function __construct() {
        ;
    }

    public static function getUserByLogin(PDO $db, $username, $password) {
        
        $st = $db->prepare("
            SELECT
                user_id
            FROM
                user
            WHERE
                username = :username
                AND
                password = :password
            ");
        
        $password = hash(HASH_ALGO, $username . $password);
        $st->bindValue(':username', $username);
        $st->bindValue(':password', $password);
        
        $st->execute();
        
        if ( $st->rowCount() != 1 ) {
            return NULL;
        }
        
        $data = $st->fetch();
        return $data['user_id'];
    }

    public static function get(PDO $db, $data) {
        $st = $db->prepare("
            SELECT
                user_id,
                username,
                password,
                gender,
                email,
                location,
                birthday,
                facebook_id,
                auth_token
            FROM
                user
            WHERE
                user_id=:id");
        $st->bindValue(':id', $data);

        $st->execute();

        if ($st->rowCount() != 1) {
            throw new UserNotFoundException;
        }

        $userData = $st->fetch();

        $user = new User;
        $user->setAuthToken($userData['auth_token']);
        $user->setBirthDay($userData['birthday']);
        $user->setEmail($userData['email']);
        $user->setFacebookId($userData['facebook_id']);
        $user->setGender($userData['gender']);
        $user->setId($userData['user_id']);
        $user->setLocation($userData['location']);
        $user->setPassword($userData['password']);
        $user->setUsername($userData['username']);

        return $user;
    }

    public static function create(PDO $db, $data) {
        # First check if the facebook_id is already known
        if (!isset($data['user_id'])) {
            $data['user_id'] = NULL;
            $data['oauth_token'] = NULL;
        }

        if ($data['user_id'] !== NULL) {
            # Check if Facebook_id exists; if yes return the user
            $st = $db->prepare("SELECT user_id FROM user WHERE facebook_id=:f");
            $st->bindValue(':f', $data['user_id']);
            $st->execute();

            if ($st->rowCount() == 1) {
                $d = $st->fetch();
                return User::get($db, $d[0]);
            }
        }

        # Check if username exists
        $st = $db->prepare("SELECT user_id FROM user WHERE username=:u");
        $st->bindValue(':u', $data['registration']['username']);
        $st->execute();

        if ($st->rowCount() > 0) {
            throw new UsernameAlreadyExistsException;
        }

        $st = $db->prepare("
            INSERT INTO user
            (
                username,
                password,
                gender,
                email,
                location,
                birthday,
                facebook_id,
                auth_token
            )
            VALUES
            (
                :username,
                :password,
                :gender,
                :email,
                :location,
                :birthday,
                :facebook_id,
                :auth_token
            )");

        $password = hash(HASH_ALGO, $data['registration']['username'] .
                $data['registration']['password']);
        $aBirthDay = explode('/', $data['registration']['birthday']);
        $birthday = sprintf('%d-%d-%d', $aBirthDay[2], $aBirthDay[0], $aBirthDay[1]);

        $st->bindValue(':username', $data['registration']['username']);
        $st->bindValue(':password', $password);
        $st->bindValue(':gender', $data['registration']['gender']);
        $st->bindValue(':email', $data['registration']['email']);
        $st->bindValue(':location', $data['registration']['location']['name']);
        $st->bindValue(':birthday', $birthday);
        $st->bindValue(':facebook_id', $data['user_id']);
        $st->bindValue(':auth_token', $data['oauth_token']);

        $st->execute();

        $id = $db->lastInsertId();

        $user = new User();
        $user->setId($id);
        $user->setUsername($data['registration']['username']);
        $user->setPassword($password);
        $user->setGender($data['registration']['gender']);
        $user->setEmail($data['registration']['email']);
        $user->setLocation($data['registration']['location']['name']);
        $user->setBirthDay($birthday);
        $user->setFacebookId($data['user_id']);
        $user->setAuthToken($data['oauth_token']);

        return $user;
    }

    public function update(PDO $db) {
        $st = $db->prepare("
            UPDATE
                user
            SET
                password = :password,
                gender = :gender
                email = :email
                location = :location
                birthday = :birthday
                facebook_id = :facebook_id
                auth_token = :auth_token
            WHERE
                user_id = :id");

        $st->bindValue(':username', $this->username);
        $st->bindValue(':password', $this->password);
        $st->bindValue(':gender', $this->gender);
        $st->bindValue(':email', $this->email);
        $st->bindValue(':location', $this->location);
        $st->bindValue(':birthday', $this->birthday);
        $st->bindValue(':facebook_id', $this->facebookId);
        $st->bindValue(':auth_token', $this->authToken);
        $st->bindValue(':id', $this->id);

        $st->execute();
    }

    protected function setId($i) {
        $this->id = $i;
    }

    protected function setUsername($u) {
        $this->username = $u;
    }

    public function setPassword($p) {
        $this->password = hash(HASH_ALGO, $this->username . $p);
    }

    public function setGender($g) {
        if ($g === 'male' || $g === 'female') {
            $this->gender = $g;
        }
    }

    public function setEmail($e) {
        $this->email = $e;
    }

    public function setLocation($l) {
        $this->location = $l;
    }

    public function setBirthDay($b) {
        $this->birthday = $b;
    }

    public function setFacebookId($f) {
        if ($f == 0 || $f == '') {
            $this->facebookId = NULL;
        } else {
            $this->facebookId = $f;
        }
    }

    public function setAuthToken($a) {
        $this->authToken = $a;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getId() {
        return $this->id;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getBirthday() {
        return $this->birthday;
    }

    public function getFacebookId() {
        return $this->facebookId;
    }

    public function getAuthToken() {
        return $this->authToken;
    }

}