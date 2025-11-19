<!DOCTYPE html>
<html lang="en">
<head>
            <style>
                .flex-container {
                  display: flex;
                  flex-wrap: wrap;
                }
                .flex-container > div {
                  width: 100px;
                  margin: 20px;
                  line-height: 75px;
                }
                div > p{
                    margin-top: -30px;
                    font-size: 19px;
                    text-align: center;
                }
            </style>
</head>
<body>
                <div class="flex-container">
    <?php 
    $data = $this->model_products->getProductData();
    foreach ($data as $key): ?>
    <div><img src= <?= base_url("/validation/uploads/QR/".$key['id'].".png") ?> alt="" width="150" heigh="150"><p><?= $key['code'];?></p>
    </div>
    <?php endforeach; ?>
                </div>
    </body>

    </html>