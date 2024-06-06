<?php

namespace class\dataAccess\server;

use Random\RandomException;

/**
 * Class TokenRepository
 *
 * This class is responsible for managing the token repository.
 */
class TokenRepository {

    private string $file = __DIR__ . '/../../../assets/data/token.json';

    /**
     * @param string $email
     * @return string : the token generated
     * @throws RandomException
     */
    public function generateToken(string $email): string
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
     * @param string $token
     * @return bool|int|string
     */
    public function validateToken(string $token): bool|int|string
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
     * @param string $email
     */
    public function removeToken(string $email): void
    {
        if (!file_exists($this->file)) {
            return;
        }

        $tokens = json_decode(file_get_contents($this->file), true);

        unset($tokens[$email]);

        file_put_contents($this->file, json_encode($tokens));
    }
}

