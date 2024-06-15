<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts - Procity Blog</title>
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/*">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="fa_icons/css/all.css">
    <script src="js/app.js"></script>
</head>
<body class="bg-slate-100">

    <?php include_once 'components/header.html'  ?>

    <div class="min-h-screen">
        <section class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-5" id="post_grid">
            
        </section>
    </div>

    <?php include_once 'components/footer.html'  ?>


    <script>
        // axios.get(`${baseUrl}/v1/posts/fetch_all.php?limit=6&category=Food`)
        axios.get(`${baseUrl}/v1/posts/fetch_all.php`)
        .then((res) => {
            console.log(res.data);
            let posts = res.data.posts;
            let postHTML = "";
            posts.map((post, index) => {
                postHTML += `<a href="blogpost.php?post_id=${post.id}" class="flex items-center">
                                <aside class="w-1/2 h-32 flex justify-center items-center overflow-hidden">
                                    <img src="${baseUrl + post.poster_image}" alt="image" class="max-w-full">
                                </aside>
                                <aside class="w-1/2">
                                    <section class="p-4">
                                        <label class="inline-block py-1 px-3 text-white text-xs bg-slate-800">
                                            ${post.category.category_name}
                                        </label>
                                        <h2 class="text-2xl font-bold my-2 line-clamp-2">
                                            ${post.title}
                                        </h2>
                                        <div class="text-sm flex gap-4 items-center text-slate-600">
                                            <span>${post.author.fullname} </span>
                                            <span> ${moment(post.created_at).fromNow()} </span>
                                        </div>
                                    </section>
                                </aside>
                            </a>`;
            })

            // Display on  html element
            document.getElementById('post_grid').innerHTML = postHTML;
        })
    </script>

</body>
</html>