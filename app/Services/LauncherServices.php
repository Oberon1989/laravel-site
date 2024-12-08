<?php

namespace App\Services;

use App\Constants\Tg\TgConstants;
use App\Events\CrashReport;
use App\Helpers\LauncherResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LauncherServices
{
    public function getResponseObj(Request $request): JsonResponse
    {
        if (!array_key_exists('email', $request->json()->all()) || !array_key_exists('password', $request->json()->all())) {
            return $this->getResponse(false, "Пропущен email или пароль!", null, null, null, 500);
        }
        $data = $request->json()->all();
        $email = $data['email'];
        $password = $data['password'];

        $user = User::where('email', $email)->first();
        if (!$user) {
            return $this->getResponse(false, "Аккаунт не найден!", null, null, null, 404);
        }
        if (!Hash::check($password, $user->password)) {
            return $this->getResponse(false, "Неверный пароль!", null, null, null, 401);
        }
        if ($user->status == -1) {
            return $this->getResponse(false, "Аккаунт забанен навсегда!", null, null, null, 401);
        }
        if ($user->status == 0) {
            return $this->getResponse(false, "Администратор еще не подтвердил вашу регистрацию!", null, null, null, 401);
        } else {
            $accessToken = $this->generateAccessToken();
            $user->accessToken = $accessToken;
            $user->save();
            return $this->getResponse(true, "Успешный вход!", $user->login, $user->uuid, $user->accessToken);
        }
    }

    public function getResponse(bool $status, string $message, string|null $login, string|null $uuid, string|null $accessToken, int $code = null): JsonResponse
    {
        if (!$code) $code = 200;
        return response()->json([
            'status' => $status,
            'message' => $message,
            'login' => $login,
            'uuid' => $uuid,
            'accessToken' => $accessToken,], $code);
    }

    private function generateAccessToken(): string
    {
        srand(time());
        $randNum = rand(1000000000, 2147483647) . rand(1000000000, 2147483647) . rand(0, 9);
        return md5($randNum);
    }

    public function launcherSendJoin(Request $request) : JsonResponse
    {

        $accessToken = $request->get('accessToken');
        $selectedProfile = $request->get('selectedProfile');
        $serverId = $request->get('serverId');
        $user = User::where('accessToken', $accessToken)
            ->where('uuid', $selectedProfile)->first();
        $result = LauncherResponse::getResponseArray($user,$serverId);
       return response()->json($result);



    }
}
