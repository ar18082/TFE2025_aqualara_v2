<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>@yield('title', 'Document')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }

        h1 {
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
        }
        h2 {
            font-size: 13px;
          
        }
        .document-container {
            /* max-width: 800px; */
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .container_title {
            border: 1px solid #000000;
            text-align: center;
            
            padding: 10px;
           
        }
        .container_immeuble {
            border: 1px solid #000000;
            padding: 10px 10px 0 10px;
           
        }
        .container_code {
            border: 1px solid #000000; 
            padding: 10px  ;
            

            & h2 {
                margin-bottom: 0;
            }
           
        }
        .content {
            margin-bottom: 30px;
        }
       
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="document-container">
        <div class="header">
            @yield('header')
        </div>

        <div class="content">
            @yield('content')
        </div>

        <div class="footer">
            @yield('footer')
        </div>
    </div>
</body>
</html> 