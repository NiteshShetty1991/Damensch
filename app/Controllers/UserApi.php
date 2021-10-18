<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use ReflectionException;

class UserApi extends BaseController
{
    // register user
    public function store()
    {
        $rules = [
            'fullname' => 'required',
            'username' => 'required|is_unique[users.username]',
            'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]|max_length[255]'
        ];
        $input = $this->getRequestInput($this->request);
        if (!$this->validateRequest($input, $rules)) {
            return $this->getResponse($this->validator->getErrors(), ResponseInterface::HTTP_BAD_REQUEST);
        }

        $userModel = new UserModel();
        $userModel->save($input);
     
        return $this->getJWTForUser($input['email'],  ResponseInterface::HTTP_CREATED);

    }
     
    // get all user
    public function index()
    {
        $userModel = new UserModel();
        return $this->getResponse(
            [
                'message' => 'Users retrieved successfully',
                'users' => $userModel->findAll()
            ]
        );
    }

    // show single user
    public function show($id)
    {
        try {

            $userModel = new UserModel();
            $user = $userModel->where('id', $id)->first();

            return $this->getResponse(
                [
                    'message' => 'User retrieved successfully',
                    'user' => $user
                ]
            );

        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find user for specified ID'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    // update user data
    public function update($id)
    {
        try {

            $userModel = new UserModel();
            $input = $this->getRequestInput($this->request);

            $userModel->update($id, $input);
            $user = $userModel->where('id', $id)->first();

            return $this->getResponse(
                [
                    'message' => 'User updated successfully',
                    'user' => $user
                ]
            );
        } catch (Exception $exception) {

            return $this->getResponse(
                [
                    'message' => $exception->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }
 
    // delete user
    public function destroy($id)
    {
        try {
            
            $userModel = new UserModel();
            $userModel->where('id', $id)->delete($id);

            return $this->getResponse(
                [
                    'message' => 'User deleted successfully',
                ]
            );
        } catch (Exception $exception) {
            return $this->getResponse(
                [
                    'message' => $exception->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }    

    private function getJWTForUser(string $emailAddress, int $responseCode = ResponseInterface::HTTP_OK)
    {
        try {
            $userModel = new UserModel();
            $user = $userModel->findUserByEmailAddress($emailAddress);
            unset($user['password']);

            helper('jwt');

            return $this
                ->getResponse(
                    [
                        'message' => 'User authenticated successfully',
                        'user' => $user,
                        'access_token' => getSignedJWTForUser($emailAddress)
                    ]
                );
        } catch (Exception $exception) {
            return $this
                ->getResponse(
                    [
                        'error' => $exception->getMessage(),
                    ],
                    $responseCode
                );
        }
    }
}
