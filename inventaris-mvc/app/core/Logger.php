<?php

class Logger {
    private static string $logDir = ROOT_PATH . '/logs/errors';

    public static function error(string $message, array $context = []): void {
        if (!is_dir(self::$logDir) && !mkdir(self::$logDir, 0777, true) && !is_dir(self::$logDir)) {
            throw new RuntimeException('Direktori log tidak dapat dibuat.');
        }

        $entry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'message' => $message,
            'context' => $context,
        ];
        $file = self::$logDir . '/error-' . date('YmdHis') . '.json';
        $written = file_put_contents(
            $file,
            json_encode($entry, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),
            LOCK_EX
        );

        if ($written === false) {
            throw new RuntimeException('Berkas log tidak dapat ditulis.');
        }
    }
}
