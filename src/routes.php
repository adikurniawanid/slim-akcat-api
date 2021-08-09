<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/[{name}]', function (Request $request, Response $response, array $args) use ($container) {
        // Sample log message
        $container->get('logger')->info("Slim-Skeleton '/' route");

        // Render index view
        return $container->get('renderer')->render($response, 'index.phtml', $args);
    });

    $app->get("/pertanyaan/", function (Request $request, Response $response) {
        $sql = "call get_pertanyaan_list()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->get("/pertanyaan/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call get_pertanyaan_detail_by_id(:id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);
        $result = $stmt->fetch();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->post("/pertanyaan/", function (Request $request, Response $response) {

        $new_pertanyaan = $request->getParsedBody();

        $sql = "call add_pertanyaan(:id_param, :kode_param, :pertanyaan_param, :kategori_id_param, :opsi_a_param, :opsi_b_param, :opsi_c_param, :opsi_d_param, :kunci_param, :gambar_param, :audio_param)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_param" => $new_pertanyaan["id_param"],
            ":kode_param" => $new_pertanyaan["kode_param"],
            ":pertanyaan_param" => $new_pertanyaan["pertanyaan_param"],
            ":kategori_id_param" => $new_pertanyaan["kategori_id_param"],
            ":opsi_a_param" => $new_pertanyaan["opsi_a_param"],
            ":opsi_b_param" => $new_pertanyaan["opsi_b_param"],
            ":opsi_c_param" => $new_pertanyaan["opsi_c_param"],
            ":opsi_d_param" => $new_pertanyaan["opsi_d_param"],
            ":kunci_param" => $new_pertanyaan["kunci_param"],
            ":gambar_param" => $new_pertanyaan["gambar_param"],
            ":audio_param" => $new_pertanyaan["audio_param"]
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->put("/pertanyaan/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $new_pertanyaan = $request->getParsedBody();
        $sql = "call edit_pertanyaan(:id_param, :pertanyaan_param, :kategori_id_param, :opsi_a_param, :opsi_b_param, :opsi_c_param, :opsi_d_param, :kunci_param, :gambar_param, :audio_param)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_param" => $new_pertanyaan["id_param"],
            ":pertanyaan_param" => $new_pertanyaan["pertanyaan_param"],
            ":kategori_id_param" => $new_pertanyaan["kategori_id_param"],
            ":opsi_a_param" => $new_pertanyaan["opsi_a_param"],
            ":opsi_b_param" => $new_pertanyaan["opsi_b_param"],
            ":opsi_c_param" => $new_pertanyaan["opsi_c_param"],
            ":opsi_d_param" => $new_pertanyaan["opsi_d_param"],
            ":kunci_param" => $new_pertanyaan["kunci_param"],
            ":gambar_param" => $new_pertanyaan["gambar_param"],
            ":audio_param" => $new_pertanyaan["audio_param"]
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->delete("/pertanyaan/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call delete_pertanyaan(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->patch("/pertanyaan/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call arsip_pertanyaan(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->get("/pertanyaan/arsip/", function (Request $request, Response $response) {
        $sql = "call get_pertanyaan_arsip_list()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->delete("/pertanyaan/arsip/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call delete_pertanyaan(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->patch("/pertanyaan/arsip/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call recovery_pertanyaan(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->get("/kategori/", function (Request $request, Response $response) {
        $sql = "call get_kategori_list()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->get("/kategori/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call get_pertanyaan_list_by_kategori_id(:id)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->post("/kategori/", function (Request $request, Response $response) {

        $new_pertanyaan = $request->getParsedBody();

        $sql = "call add_kategori(:id_param, :kode_param, :nama_param, :nilai_param)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_param" => $new_pertanyaan["id_param"],
            ":kode_param" => $new_pertanyaan["kode_param"],
            ":nama_param" => $new_pertanyaan["nama_param"],
            ":nilai_param" => $new_pertanyaan["nilai_param"],
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->put("/kategori/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $new_pertanyaan = $request->getParsedBody();
        $sql = "call edit_kategori(:id_param, :nama_param, :nilai_param)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_param" => $new_pertanyaan["id_param"],
            ":nama_param" => $new_pertanyaan["nama_param"],
            ":nilai_param" => $new_pertanyaan["nilai_param"]
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->delete("/kategori/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call delete_kategori(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->patch("/kategori/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call arsip_kategori(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->get("/kategori/arsip/", function (Request $request, Response $response) {
        $sql = "call get_kategori_arsip_list()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->delete("/kategori/arsip/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call delete_kategori(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->patch("/kategori/arsip/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call recovery_kategori(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->get("/peserta/", function (Request $request, Response $response) {
        $sql = "call get_peserta_list()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->post("/peserta/", function (Request $request, Response $response) {

        $new_peserta = $request->getParsedBody();

        $sql = "call add_peserta(:id_param, :username_param, :email_param, :password_param, :nama_param, :jenis_kelamin_id_param, :no_hp_param, :instansi_param)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_param" => $new_peserta["id_param"],
            ":username_param" => $new_peserta["username_param"],
            ":email_param" => $new_peserta["email_param"],
            ":password_param" => $new_peserta["password_param"],
            ":nama_param" => $new_peserta["nama_param"],
            ":jenis_kelamin_id_param" => $new_peserta["jenis_kelamin_id_param"],
            ":no_hp_param" => $new_peserta["no_hp_param"],
            ":instansi_param" => $new_peserta["instansi_param"]
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->put("/peserta/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $new_peserta = $request->getParsedBody();
        $sql = "call edit_peserta(:id_param, :email_param, :password_param, :nama_param, :jenis_kelamin_id_param, :no_hp_param, :instansi_param)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_param" => $new_peserta["id_param"],
            ":email_param" => $new_peserta["email_param"],
            ":password_param" => $new_peserta["password_param"],
            ":nama_param" => $new_peserta["nama_param"],
            ":jenis_kelamin_id_param" => $new_peserta["jenis_kelamin_id_param"],
            ":no_hp_param" => $new_peserta["no_hp_param"],
            ":instansi_param" => $new_peserta["instansi_param"]
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->delete("/peserta/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call delete_peserta(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->patch("/peserta/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call arsip_peserta(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->get("/peserta/arsip/", function (Request $request, Response $response) {
        $sql = "call get_peserta_arsip_list()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->delete("/peserta/arsip/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call delete_peserta(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->patch("/peserta/arsip/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call recovery_peserta(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->get("/sesi-ujian/", function (Request $request, Response $response) {
        $sql = "call get_sesi_ujian_list()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->post("/sesi-ujian/", function (Request $request, Response $response) {

        $new_sesi_ujian = $request->getParsedBody();

        $sql = "call add_sesi_ujian(:id_param, :kode_param, :nama_param, :tempat_ujian_param, :waktu_mulai_param, :durasi_param)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_param" => $new_sesi_ujian["id_param"],
            ":kode_param" => $new_sesi_ujian["kode_param"],
            ":nama_param" => $new_sesi_ujian["nama_param"],
            ":tempat_ujian_param" => $new_sesi_ujian["tempat_ujian_param"],
            ":waktu_mulai_param" => $new_sesi_ujian["waktu_mulai_param"],
            ":durasi_param" => $new_sesi_ujian["durasi_param"]
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->put("/sesi-ujian/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $new_sesi_ujian = $request->getParsedBody();
        $sql = "call edit_sesi_ujian(:id_param, :nama_param, :tempat_ujian_param, :waktu_mulai_param, :durasi_param)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id_param" => $new_sesi_ujian["id_param"],
            ":nama_param" => $new_sesi_ujian["nama_param"],
            ":tempat_ujian_param" => $new_sesi_ujian["tempat_ujian_param"],
            ":waktu_mulai_param" => $new_sesi_ujian["waktu_mulai_param"],
            ":durasi_param" => $new_sesi_ujian["durasi_param"]
        ];
        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->delete("/sesi-ujian/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call delete_sesi_ujian(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->patch("/sesi-ujian/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call arsip_sesi_ujian(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->get("/sesi-ujian/arsip/", function (Request $request, Response $response) {
        $sql = "call get_sesi_ujian_arsip_list()";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $response->withJson(["status" => "success", "data" => $result], 200);
    });

    $app->delete("/sesi-ujian/arsip/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call delete_sesi_ujian(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });

    $app->patch("/sesi-ujian/arsip/{id}", function (Request $request, Response $response, $args) {
        $id = $args["id"];
        $sql = "call recovery_sesi_ujian(:id)";
        $stmt = $this->db->prepare($sql);

        $data = [
            ":id" => $id
        ];

        if ($stmt->execute($data))
            return $response->withJson(["status" => "success", "data" => "1"], 200);

        return $response->withJson(["status" => "failed", "data" => "0"], 200);
    });
};
