<?php

namespace Billplz\Four;

use Laravie\Codex\Support\MultipartRequest;

class Collection extends Request
{
    use MultipartRequest;

    /**
     * Create a new collection.
     *
     * @param  string  $title
     * @param  array  $optional
     *
     * @return \Laravie\Codex\Response
     */
    public function create($title, array $optional = [])
    {
        $files = [];
        $body = array_merge(compact('title'), $optional);

        if (isset($body['logo'])) {
            $files['logo'] = ltrim($body['logo'], '@');
            unset($body['logo']);
        }

        list($headers, $stream) = $this->prepareMultipartRequestPayloads([], $body, $files);

        return $this->send('POST', 'collections', $headers, $stream);
    }

    /**
     * Get collection.
     *
     * @param  string  $id
     *
     * @return \Laravie\Codex\Response
     */
    public function get($id)
    {
        return $this->send('GET', "collections/{$id}", [], []);
    }

    /**
     * Get collection index.
     *
     * @return \Laravie\Codex\Response
     */
    public function index(array $optional = [])
    {
        return $this->send('GET', 'collections', [], $optional);
    }

    /**
     * Create a new open collection.
     *
     * @param  string  $title
     * @param  string  $description
     * @param  \Money\Money|int  $amount
     * @param  array  $optional
     *
     * @return \Laravie\Codex\Response
     */
    public function createOpen($title, $description, $amount, array $optional = [])
    {
        $body = array_merge(compact('title', 'description', 'amount'), $optional);

        return $this->send('POST', 'open_collections', [], $body);
    }

    /**
     * Get open collection.
     *
     * @param  string  $id
     *
     * @return \Laravie\Codex\Response
     */
    public function getOpen($id)
    {
        return $this->send('GET', "open_collections/{$id}", [], []);
    }

    /**
     * Get open collection index.
     *
     * @param  array  $optional
     *
     * @return \Laravie\Codex\Response
     */
    public function indexOpen(array $optional = [])
    {
        return $this->send('GET', 'open_collections', [], $optional);
    }

    /**
     * Activate a collection.
     *
     * @param  string  $id
     *
     * @return \Laravie\Codex\Response
     */
    public function activate($id)
    {
        return $this->send('POST', "collections/{$id}/activate", [], []);
    }

    /**
     * Deactivate a collection.
     *
     * @param  string  $id
     *
     * @return \Laravie\Codex\Response
     */
    public function deactivate($id)
    {
        return $this->send('POST', "collections/{$id}/deactivate", [], []);
    }

    /**
     * Get mass payment instruction collection resource.
     *
     * @return object
     */
    public function massPayment()
    {
        return $this->client->resource('Collection.MassPayment', $this->getVersion());
    }
}
