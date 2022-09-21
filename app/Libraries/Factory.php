<?php

namespace App\Libraries;

use Exception;
use Throwable;

class Factory
{
    /**
     * Fetches all results.
     *
     * @param mixed $model
     * @param mixed $options
     * @param mixed $limit
     *
     * @return array
     */
    public function getAll($model, $options = [], $limit = 15)
    {
        try {

            $results = $model->orderBy('created_at', 'DESC')->paginate($limit);

            // if options
            if ($options) {
                // return data by options => ['user_id' => 1]
                $results = $model->where($options)->orderBy('created_at', 'DESC')->paginate($limit);
            }

            $response = [
                'success' => true,
                'error' => false,
                'results' => count($results),
                'data' => $results,
                'message' => lang('Success.success'),
            ];
        } catch (Exception | Throwable $e) {
            $response = [
                'success' => false,
                'error' => true,
                'data' => null,
                'message' => $e->getMessage(),
            ];
        }

        return $response;
    }

    /**
     * Inserts data into the database.
     *
     * @param mixed             $model
     * @param null|array|object $payload Data
     *
     * @return array|object
     */
    public function createOne($model, array $payload = [])
    {
        try {
            $model = $model->insert($payload, true);

            $response = [
                'success' => true,
                'error' => false,
                'data' => $model,
                'message' => lang('Success.created'),
            ];
        } catch (Exception | Throwable $e) {
            $response = [
                'success' => false,
                'error' => true,
                'data' => null,
                'message' => $e->getMessage(),
            ];
        }

        return $response;
    }

    /**
     * Updates a single record in the database.
     *
     * @param mixed                 $model
     * @param null|array            $payload
     * @param null|array|int|string $id
     */
    public function updateOne($model, array $payload = [], $id = null)
    {
        try {
            $model = $model->update($id, $payload);

            $response = [
                'success' => true,
                'error' => false,
                'data' => $model,
                'message' => lang('Success.updated'),
            ];
        } catch (Exception | Throwable $e) {
            $response = [
                'success' => false,
                'error' => true,
                'data' => null,
                'message' => $e->getMessage(),
            ];
        }

        return $response;
    }

    /**
     * Fetches the row of database.
     *
     * @param mixed                 $model
     * @param null|array|int|string $id    One primary key or an array of primary keys
     *
     * @return null|array|object the resulting row of data, or null
     */
    public function getOne($model, $id = null)
    {
        try {
            $model = $model->find($id);

            $response = [
                'success' => true,
                'error' => false,
                'data' => $model,
                'message' => lang('Success.success'),
            ];
        } catch (Exception | Throwable $e) {
            $response = [
                'success' => false,
                'error' => true,
                'data' => null,
                'message' => $e->getMessage(),
            ];
        }

        return $response;
    }

    /**
     * Deletes a single record from the database where $id matches.
     *
     * @param mixed                 $model
     * @param null|array|int|string $id    The rows primary key(s)
     */
    public function deleteOne($model, $id = null)
    {
        try {
            $model->delete($id);

            $response = [
                'success' => true,
                'error' => false,
                'data' => null,
                'message' => lang('Success.deleted'),
            ];
        } catch (Exception | Throwable $e) {
            $response = [
                'success' => false,
                'error' => true,
                'data' => null,
                'message' => $e->getMessage(),
            ];
        }

        return $response;
    }
}
