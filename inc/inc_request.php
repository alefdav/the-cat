<?php

define('API_KEY', 'live_7da2qj0qMVgf6uWibHKPdMqSpe46bQzTBmZJXOU9ILk2PqR67XfmXMA0NlBbmt3B');

class CatAPI {
    private $api_key;
    private $base_url = 'https://api.thecatapi.com/v1';
    private $cache_time = 3600; // 1 hora em segundos

    public function __construct($api_key) {
        $this->api_key = $api_key;
    }

    /**
     * Realiza requisição HTTP para a API
     * @param string $endpoint
     * @param string $method
     * @param array $data
     * @return array
     */
    private function request($endpoint, $method = 'GET', $data = null) {
        $curl = curl_init();
        
        $options = [
            CURLOPT_URL => $this->base_url . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'x-api-key: ' . $this->api_key,
                'Content-Type: application/json'
            ]
        ];

        if ($method === 'POST') {
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        } elseif ($method === 'DELETE') {
            $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
        }

        curl_setopt_array($curl, $options);
        
        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return ['erro' => $error];
        }
        
        curl_close($curl);
        return [
            'status' => $http_code,
            'data' => json_decode($response, true)
        ];
    }

    /**
     * Lista todas as raças disponíveis
     * @param int $limit Limite de resultados por página
     * @param int $page Número da página
     * @param array $params Parâmetros adicionais de busca
     * @return array
     */
    public function listarRacas($limit = 10, $page = 0, $params = []) {
        // Criar chave única para cache
        $cache_key = 'cat_breeds_' . md5(serialize([$limit, $page, $params]));
        
        // Tentar obter do cache primeiro
        $cached_response = get_transient($cache_key);
        if ($cached_response !== false) {
            return $cached_response;
        }

        // Preparar parâmetros da requisição
        $default_params = [
            'limit' => $limit,
            'page' => $page,
            'has_breeds' => 1
        ];
        
        $params = array_merge($default_params, $params);
        $query = http_build_query($params);
        
        // Fazer requisição única incluindo header para total
        $curl = curl_init($this->base_url . '/breeds?' . $query);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'x-api-key: ' . $this->api_key
            ],
            CURLOPT_HEADER => true
        ]);
        
        $response = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headers = $this->parseHeaders(substr($response, 0, $header_size));
        $body = json_decode(substr($response, $header_size), true);
        
        // Filtrar apenas gatos que têm URL de imagem
        $body = array_filter($body, function($cat) {
            return !empty($cat['image']) && !empty($cat['image']['url']);
        });
        
        $total = isset($headers['pagination-count']) ? $headers['pagination-count'] : count($body);
        
        $result = [
            'data' => array_values($body), // array_values para reindexar o array
            'total' => $total
        ];
        
        // Armazenar no cache
        set_transient($cache_key, $result, $this->cache_time);
        
        return $result;
    }

    private function parseHeaders($headers) {
        $parsed = [];
        foreach (explode("\n", $headers) as $line) {
            $parts = explode(':', $line, 2);
            if (isset($parts[1])) {
                $parsed[strtolower(trim($parts[0]))] = trim($parts[1]);
            }
        }
        return $parsed;
    }

    /**
     * Pesquisa raças com filtros
     * @param array $params Parâmetros de busca
     * @return array
     */
    public function pesquisarRacas($params = []) {
        $query = http_build_query($params);
        $response = $this->request('/breeds/search?' . $query);
        
        // Adiciona o total de resultados à resposta de pesquisa
        if (isset($response['data'])) {
            $search_term = isset($params['q']) ? $params['q'] : '';
            $all_results = $this->request('/breeds/search?q=' . urlencode($search_term))['data'];
            $response['total'] = count($all_results);
        }
        
        return $response;
    }

    /**
     * Lista todos os favoritos do usuário
     * @param int $limit Limite de resultados
     * @param int $page Página atual
     * @return array
     */
    public function listarFavoritos($limit = 10, $page = 0) {
        return $this->request("/favourites?limit={$limit}&page={$page}");
    }

    /**
     * Verifica se uma imagem está nos favoritos
     * @param string $image_id ID da imagem a ser verificada
     * @return bool
     */
    public function isFavorited($image_id) {
        static $favorites = null;
        
        if ($favorites === null) {
            $favorites = $this->getFavorites();
        }
        
        return isset($favorites[$image_id]) ? $favorites[$image_id] : false;
    }

    /**
     * Método para adicionar favorito
     * @param string $image_id ID da imagem a ser adicionada aos favoritos
     * @return bool|array Retorna os dados da resposta ou false em caso de falha
     */
    public function addFavorite($image_id) {
        if (!is_user_logged_in()) {
            return false;
        }

        $response = $this->request('/favourites', 'POST', [
            'image_id' => $image_id
        ]);

        if ($response['status'] === 200) {
            return $response['data'];
        }
        
        return false;
    }

    /**
     * Remove uma imagem dos favoritos
     * @param string $favorite_id ID do favorito a ser removido
     * @return bool Retorna true se removido com sucesso, false caso contrário
     */
    public function removeFavorite($favorite_id) {
        // echo var_dump($favorite_id);
        $response = $this->request("/favourites/{$favorite_id}", 'DELETE');
        
        return $response['status'] === 200;
    }

    /**
     * Lista todos os favoritos do usuário atual
     * @return array
     */
    public function getFavorites() {
        if (!is_user_logged_in()) {
            return [];
        }

        $response = $this->request("/favourites?sub_id=" . get_current_user_id());
        
        if ($response['status'] === 200) {
            return $response['data'];
        }
        
        return [];
    }
}

