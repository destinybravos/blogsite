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
</head>
<body class="bg-slate-100">

    <?php include_once 'components/header.html'  ?>

    <div class="min-h-screen">

        <section class="max-w-6xl mx-auto my-10 flex gap-5 justify-between items-start relative">
            <!-- Main Post Content -->
            <aside class="w-4/6">
                <article>
                    <h1 class="text-4xl font-bold mb-5" id="post_title"></h1>
                    <div class="text-sm flex gap-4 items-center divide-x-2 mb-5">
                        <span id="author" class="inline-flex items-center gap-2"></span>
                        <span id="date_created" class="text-slate-500 pl-3"></span>
                    </div>

                    <!-- Feature Image -->
                    <div class="max-w-full p-4 mb-5">
                        <img src="" alt="" class="max-w-full" id="post_image">
                    </div>

                    <div id="post_body" class="mb-4">

                    </div>

                </article>
            </aside>

            <!-- Side (Related Content) -->
            <aside class="min-h-40 w-2/6 sticky top-36">
                <h1 class="mb-2 text-xl font-bold">Related Articles</h1>

                <div id="related_content">

                </div>
            </aside>
        </section>
       
    </div>

    <?php include_once 'components/footer.html'  ?>

    <script>
        // Get the url parameter
        let url = new URL(location.href)
        let postId = url.searchParams.get('post_id');

        // Make the request to get the post details
        let formData = new FormData();
        formData.append('post_id', postId);

        axios.post(`${baseUrl}/v1/posts/fetch_details.php`, formData)
        .then((res) => {
            let post = res.data.post;
            fetchOtherPosts(post.id, post.category.category_name)
            // Adding the data to the HTML Elements
            document.getElementById('post_title').innerText = post.title;
            document.getElementById('date_created').innerText = moment(post.created_at).format('MMMM Do YYYY, h:mm:ss a')

            let authorHtml = `<div id="${post.author.id}" class="h-12 w-12 rounded-full bg-slate-400 overflow-hidden">
                                <img src="${post.author.avatar}" alt=" " class="object-cover">
                            </div>
                            <h3 class="text-base font-bold">
                                ${post.author.fullname}
                            </h3>`;
            document.getElementById('author').innerHTML = authorHtml;

            document.getElementById('post_image').setAttribute('src', baseUrl + post.poster_image);
            document.getElementById('post_body').innerHTML = post.content;
        })

        let fetchOtherPosts = (postId, category) => {
            let postHTML = "";
            axios.get(`${baseUrl}/v1/posts/fetch_all.php?exempt=${postId}&category=${category}`)
            .then((res) => {
                let posts = res.data.posts;
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
                document.getElementById('related_content').innerHTML = postHTML;
            })
        }
        
        
    </script>
</body>
</html>