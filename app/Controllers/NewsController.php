<?php

namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\NewsModel;
use CodeIgniter\Controller;

class NewsController extends Controller
{

    public function detail($id)
    {
        $newsModel = new NewsModel();
        $commentModel = new CommentModel();

        // Mengambil ID berita
        $newsId = $newsModel->getNewsId($id);

        if (!$newsId) {
            return "Berita tidak ditemukan.";
        }

        // Mengambil berita dengan informasi kategori
        $data['news'] = $newsModel->getNewsWithAuthorAndCategory($newsId);

        // Mengambil komentar untuk berita ini
        $data['comments'] = $commentModel->getCommentsByNewsId($newsId);

        // Menambahkan ID ke dalam data untuk dikirimkan ke view
        $data['id'] = $id;

        echo view('layout/header');
        echo view('layout/navbar');
        echo view('news', $data);
    }

    public function create()
    {
        helper(['form', 'url']);

        if ($this->request->getMethod() === 'post') {
            $validationRules = [
                'title' => 'required',
                'content' => 'required',
                'category_id' => 'required|integer',
                'author_id' => 'required|integer',
                'created_at' => 'valid_date[Y-m-d H:i:s]',
                'updated_at' => 'valid_date[Y-m-d H:i:s]',
                'image' => 'uploaded[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
            ];

            if ($this->validate($validationRules)) {
                $newsModel = new NewsModel();
                $image = $this->request->getFile('image');
                $newName = $image->getRandomName();
                $image->move('assets/', $newName);

                $data = [
                    'title' => $this->request->getPost('title'),
                    'content' => $this->request->getPost('content'),
                    'category_id' => $this->request->getPost('category_id'),
                    'author_id' => $this->request->getPost('author_id'),
                    'created_at' => $this->request->getPost('created_at'),
                    'updated_at' => $this->request->getPost('updated_at'),
                    'image' => $newName,
                ];

                $newsModel->insert($data);

                return redirect()->to('/');
            } else {
                // Simpan pesan kesalahan menggunakan Flashdata
                session()->setFlashdata('errors', $this->validator->getErrors());

                return redirect()->back()->withInput();
            }
        }

        echo view('layout/header');
        echo view('layout/navbar');
        echo view('inputberita');
    }

    public function update($id)
    {
        $model = new NewsModel();

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'title'       => 'required',
                'content'     => 'required',
                'category_id' => 'required|integer',
            ];

            // Cek apakah ada file gambar yang diunggah
            if (!empty($_FILES['image']['name'])) {
                $rules['image'] = 'uploaded[image]|mime_in[image,image/jpg,image/jpeg,image/png]';
            }

            if (!$this->validate($rules)) {
                return redirect()->to("auth/update/$id")->withInput()->with('validation', $this->validator);
            }

            $data = [
                'title'       => $this->request->getPost('title'),
                'content'     => $this->request->getPost('content'),
                'category_id' => $this->request->getPost('category_id'),
            ];

            // Cek apakah ada file gambar yang diunggah
            if (!empty($_FILES['image']['name'])) {
                $image = $this->request->getFile('image');
                $newName = $image->getRandomName();
                $image->move('assets/', $newName);
                $data['image'] = $newName;
            }

            $model->update($id, $data);

            return redirect()->to('/auth/manajement');
        }

        // Fetch the article details for the update form
        $data['article'] = $model->find($id);

        echo view('layout/header');
        echo view('layout/navbar');
        echo view('updateberita', $data);
    }

    public function delete($id)
    {
        $newsModel = new NewsModel();
        $newsModel->delete($id);

        // Redirect ke halaman utama atau halaman lain setelah penghapusan
        return redirect()->to('/');
    }
}