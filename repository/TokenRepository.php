<?php

namespace repository;

use Random\RandomException;

/**
 * Class TokenRepository
 *
 * This class is responsible for managing the token repository.
 */
class TokenRepository {
    private string $file = '../assets/token.json';

    /**
     * @throws RandomException
     */
    public function generateToken($email): string
    {
        $token = bin2hex(random_bytes(16));
        $tokens = [];

        if (file_exists($this->file)) {
            $tokens = json_decode(file_get_contents($this->file), true);
        }

        $tokens[$email] = [
            'token' => $token,
            'created' => time()
        ];

        file_put_contents($this->file, json_encode($tokens));

        return $token;
    }

    /**
     * @param $token
     * @return bool|int|string
     */
    public function validateToken($token): bool|int|string
    {
        if (!file_exists($this->file)) {
            return false;
        }

        $tokens = json_decode(file_get_contents($this->file), true);

        foreach ($tokens as $email => $data) {
            if ($data['token'] === $token && (time() - $data['created']) < 900) { // 15 minutes
                return $email;
            }
        }

        return false;
    }

    /**
     * @param $email
     */
    public function removeToken($email): void
    {
        if (!file_exists($this->file)) {
            return;
        }

        $tokens = json_decode(file_get_contents($this->file), true);

        unset($tokens[$email]);

        file_put_contents($this->file, json_encode($tokens));
    }
}
?>
