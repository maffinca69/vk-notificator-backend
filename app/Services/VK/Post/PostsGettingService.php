<?php

namespace App\Services\VK\Post;

use App\Infrastructure\VK\Client\Exception\VKAPIHttpClientException;
use App\Infrastructure\VK\Client\HttpClient;
use App\Infrastructure\VK\Client\Request\WallGetByIdRequest;
use App\Models\VKUser;
use App\Services\VK\DTO\Post\PostDTO;
use App\Services\VK\Post\Assembler\PostDTOAssembler;

class PostsGettingService
{
    public function __construct(
        private HttpClient $client,
        private PostDTOAssembler $postDTOAssembler
    ) {
    }

    /**
     * @param VKUser $VKUser
     * @param array $postIds
     * @return array<PostDTO>
     * @throws VKAPIHttpClientException
     */
    public function get(VKUser $VKUser, array $postIds): array
    {
        $accessToken = $VKUser->getAccessToken();
        $request = new WallGetByIdRequest($postIds, $accessToken);

        $response = $this->client->sendRequest($request);

        $result = [];
        foreach ($response as $post) {
            $result[] = $this->postDTOAssembler->create($post);
        }

        return $result;
    }
}
