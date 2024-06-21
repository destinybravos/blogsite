<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procity Blog</title>
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/*">
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="fa_icons/css/all.css">
    <script src="js/app.js"></script>
    <!-- <script>
        alert('Hello');
    </script> -->
</head>
<body class="bg-slate-100">

    <?php include_once 'components/header.html'  ?>

    <div class="min-h-screen">
        <div class="max-w-6xl mx-auto px-4">
            <!-- Featured Post -->
            <section id="latest_content" class="min-h-96 mb-10 grid grid-cols-1 md:grid-cols-2 gap-4 py-6 box-content">
            
                <div class="flex justify-center items-center md:col-span-2">
                    <i class="fas fa-circle-notch fa-spin fa-4x"></i>
                </div>
            
            </section>

            <!-- Other Posts in the category -->
            <section class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-5 " id="post_grid"></section>
        </div>
    </div>

    <?php include_once 'components/footer.html'  ?>

    <script>

        let url = new URL(location.href);
        let category = null;
        if (url.searchParams.has('category_name')) {
            category = url.searchParams.get('category_name')
        } else {
            location.href = 'index.php';
        }

        axios.get(`${baseUrl}/v1/posts/fetch_all.php?category=${category}`)
        .then((res) => {
            console.log(res.data);
            let posts = res.data.posts;
            let postHTML = "";
            let latest = "";
            posts.map((post, index) => {
                if(index == 0){
                    latest =`<a href="blogpost.php?post_id=${post.id}" class="bg-indigo-400 block row-span-3 bg-cover bg-center bg-no-repeat" style="background-image: url('${baseUrl + post.poster_image}');">
                                <aside class="flex items-end w-full min-h-96 md:min-h-auto bg-gradient-to-b from-transparent via-transparent to-[#00000089]">
                                    
                                </aside>
                            </a>
                            <article class="relative">
                                <h1 class="text-4xl font-bold mb-5 line-clamp-2" id="post_title">${post.title}</h1>
                                <div class="text-sm flex gap-4 items-center divide-x-2 mb-5">
                                    <span id="author" class="inline-flex items-center gap-2">
                                        <div id="${post.author.id}" class="h-12 w-12 rounded-full bg-slate-400 overflow-hidden">
                                            <img src="${post.author.avatar}" alt=" " class="object-cover">
                                        </div>
                                        <h3 class="text-base font-bold">
                                            ${post.author.fullname}
                                        </h3>
                                    </span>
                                    <span id="date_created" class="text-slate-500 pl-3">${moment(post.created_at).format('MMMM Do YYYY, h:mm:ss a')}</span>
                                </div>
                                <div id="post_body" class="mb-4 line-clamp-6">
                                    ${post.content}
                                </div>

                                <div class="h-full w-full absolute top-0 left-0 bg-gradient-to-b from-transparent to-white flex items-end justify-center">
                                    <a href="blogpost.php?post_id=${post.id}" class="py-1 px-2 bg-blue-500 text-white rounded-md text-sm"> Read Post </a>
                                </div>
                            </article>
                            `
                }else{
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
                }
            })

            // Display on  html element
            document.getElementById('post_grid').innerHTML = postHTML;
            document.getElementById('latest_content').innerHTML = latest;
        })
    </script>
</body>
</html>