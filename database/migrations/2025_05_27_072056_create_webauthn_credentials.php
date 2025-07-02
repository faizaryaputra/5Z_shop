<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laragear\WebAuthn\Models\WebAuthnCredential;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('webauthn_credentials')) {
            WebAuthnCredential::migration(function (Blueprint $table) {
                //
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('webauthn_credentials');
    }
};
