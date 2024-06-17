<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <title>USILIBOT</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
    <script src="./scripts/jquery.js"></script>
    <link rel="stylesheet" href="./css/app-chat.dist.css">
    <link rel="stylesheet" href="./css/bootstrap-maxlength.dist.css">
    <link rel="stylesheet" href="./css/demo.css">
    <link rel="stylesheet" href="./css/core.dist.css">
    <link rel="stylesheet" href="./css/theme-semi-dark.dist.css">
    <link rel="stylesheet" href="./css/typeahead.dist.css">
    <link rel="stylesheet" href="./css/perfect-scrollbar.dist.css">
    <link rel="stylesheet" href="./css/app.css">

</head>

<body>
    <img src="./img/image.png" alt="" class="img-backgroid" />
    <div class="app-chat overflow-hidden d-flex justify-content-end align-items-end">
        <!-- Chat History -->
        <div class="app-chat-history bg-body">
            <div class="chat-history-wrapper">
                <div class="chat-history-header border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex overflow-hidden align-items-center">
                            <i class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-contacts"></i>
                            <div class="flex-shrink-0 avatar">
                                <img src="./img/avatars/2.png" alt="Avatar" class="rounded-circle" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right">
                            </div>
                            <div class="chat-contact-info flex-grow-1 ms-3">
                                <h6 class="m-0">Felecia Rower</h6>
                                <small class="user-status text-muted">NextJS developer</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bx bx-phone-call cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                            <i class="bx bx-video cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                            <i class="bx bx-search cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                            <div class="dropdown d-flex align-self-center">
                                <button class="btn p-0" type="button" id="chat-header-actions" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="chat-header-actions">
                                    <a class="dropdown-item" href="javascript:void(0);">View Contact</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Mute Notifications</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Block Contact</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Clear Chat</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Report</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chat-history-body bg-body">
                    <ul class="list-unstyled chat-history mb-0">
                        <li class="chat-message chat-message-right">
                            <div class="d-flex overflow-hidden">
                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-text">
                                        <p class="mb-0">How can we help? We're here for you! 😄</p>
                                    </div>
                                    <div class="text-end text-muted mt-1">
                                        <i class='bx bx-check-double text-success'></i>
                                        <small>10:00 AM</small>
                                    </div>
                                </div>
                                <div class="user-avatar flex-shrink-0 ms-3">
                                    <div class="avatar avatar-sm">
                                        <img src="./img/avatars/1.png" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="chat-message">
                            <div class="d-flex overflow-hidden">
                                <div class="user-avatar flex-shrink-0 me-3">
                                    <div class="avatar avatar-sm">
                                        <img src="./img/avatars/2.png" alt="Avatar" class="rounded-circle">
                                    </div>
                                </div>
                                <div class="chat-message-wrapper flex-grow-1">
                                    <div class="chat-message-text">
                                        <p class="mb-0">Hey John, I am looking for the best admin template.</p>
                                        <p class="mb-0">Could you please help me to find it out? 🤔</p>
                                    </div>
                                    <div class="chat-message-text mt-2">
                                        <p class="mb-0">It should be Bootstrap 5 compatible.</p>
                                    </div>
                                    <div class="text-muted mt-1">
                                        <small>10:02 AM</small>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                    </ul>
                </div>
                <!-- Chat message form -->
                <div class="chat-history-footer shadow-sm">
                    <form class="form-send-message d-flex justify-content-between align-items-center ">
                        <input class="form-control message-input border-0 me-3 shadow-none" placeholder="Type your message here">
                        <div class="message-actions d-flex align-items-center">
                            <i class="speech-to-text bx bx-microphone bx-sm cursor-pointer"></i>
                            <label for="attach-doc" class="form-label mb-0">
                                <i class="bx bx-paperclip bx-sm cursor-pointer mx-3"></i>
                                <input type="file" id="attach-doc" hidden>
                            </label>
                            <button class="btn btn-primary d-flex send-msg-btn">
                                <i class="bx bx-paper-plane me-md-1 me-0"></i>
                                <span class="align-middle d-md-inline-block d-none">Enviar</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Chat History -->
    </div>
</body>



</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="./scripts/app-chat.dist.js"></script>
<script src="./scripts/perfect-scrollbar.dist.js"></script>
<script src="./scripts/bootstrap-maxlength.dist.js"></script>