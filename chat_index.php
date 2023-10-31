<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <title>Whatsapp 2</title>
  <link rel="stylesheet" type="text/css" href="./css/chat_style.css">
</head>

<body>
  <section style="background-color: #CDC4F9;">
    <div class="container py-5">

      <div class="row">
        <div class="col-md-12">

          <div class="card" id="chat3" style="border-radius: 15px;">
            <div class="card-body">

              <div class="row">
                <!-- Barra de búsqueda y amistades -->
                <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

                  <div class="p-3">
                    <!-- Barra de búsqueda -->
                    <div class="input-group rounded mb-3">
                      <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                        aria-describedby="search-addon" />
                      <span class="input-group-text border-0" id="search-addon">
                        <i class="fas fa-search"></i>
                      </span>
                    </div>
                    <!-- Amistades -->
                    <div data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">
                      <ul class="list-unstyled mb-0">
                        <li class="p-2">
                          <a href="#!" class="d-flex justify-content-between">
                            <div class="d-flex flex-row">
                              <div>
                                <span class="badge bg-success badge-dot"></span>
                              </div>
                              <div class="pt-1">
                                <p class="fw-bold mb-0">Ben Smith</p>
                              </div>
                            </div>
                          </a>
                        </li>
                      </ul>
                    </div>

                  </div>

                </div>
                <!-- Chat general -->
                <div class="col-md-6 col-lg-7 col-xl-8">
                  <!-- Listado de mensajes -->
                  <div class="pt-3 pe-3" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px">

                    <div class="d-flex flex-row justify-content-start">
                      <div>
                        <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">Mensaje</p>
                        <p class="small ms-3 mb-3 rounded-3 text-muted float-end">12:00 PM | Aug 13</p>
                      </div>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                      <div>
                        <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">respuesta</p>
                        <p class="small me-3 mb-3 rounded-3 text-muted">12:00 PM | Aug 13</p>
                      </div>
                    </div>
                  </div>
                <!-- Barra enviar mensaje -->
                  <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                    <input type="text" class="form-control form-control-lg" id="exampleFormControlInput2"
                      placeholder="Type message">
                    <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                    <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                    <a class="ms-3" href="#!"><i class="fas fa-paper-plane"></i></a>
                  </div>

                </div>
              </div>

            </div>
          </div>

        </div>
      </div>

    </div>
  </section>
</body>

</html>