if (document.getElementById("myDropdownMenu")) {
    function myFunctionMenu() {
        console.log('clicked');
        document.getElementById("myDropdownMenu").classList.add("show-menu");
    }
}

if (document.getElementById("myDropdown")) {
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function (event) {
    if (!event.target.matches(".movie_btn")) {
        let moviebtns = document.getElementsByClassName("movie_drop");
        let i;
        for (i = 0; i < moviebtns.length; i++) {
            let openDropdown = moviebtns[i];
            if (openDropdown.classList.contains("show")) {
                openDropdown.classList.remove("show");
            }
        }
    }
};

window.onclick = function (event) {
    if (!event.target.matches(".header_blocks_dropdown")) {
        let loginBtns = document.getElementsByClassName("dropdown_drop_menu");
        let i;
        for (i = 0; i < loginBtns.length; i++) {
            let openDropdownMenu = loginBtns[i];
            if (openDropdownMenu.classList.contains("show-menu")) {
                openDropdownMenu.classList.remove("show-menu");
            }
        }
    }
};

function addDelFilmInList(user_id, film_id, list_id, new_list_id) {
    $.ajax({
        type: "POST",
        url: "/add_del_film_in_list",
        data: {
            user_id: user_id,
            film_id: film_id,
            list_id: list_id,
            new_list_id: new_list_id
        },
        success: function (response) {
            $("#film_lists").html(response);
        }
    });
}

$('#searchForm').on('submit', function (event) {
    event.preventDefault();

    let data = $('#searchForm').serialize();

    $.ajax({
        url: "/filter",
        type: "POST",
        data: data,
        success: function (response) {
            $("#search_results").html(response);
        },
    });
});

function addDelFilmInFavorites(e, list_id, film_id) {
    e.preventDefault();

    let class_name = 'icon_chosen_';

    if (list_id === 2) {
        class_name = 'icon_favorite_';
    } else if (list_id === 3) {
        class_name = 'icon_must_see_';
    }

    $.ajax({
        type: "POST",
        url: "/add_del_film_in_favorites",
        data: {
            'film_id': film_id,
            'list_id': list_id,
        },
        success: function (response) {
            $('svg.' + class_name + film_id).each(function () {
                $(this).replaceWith(response);
            });
        }
    });
}

function addDelEmoji(e, film_id, emoji_id, count) {
    e.preventDefault();

    let emoji_id_name = 'emoji_good';

    if (emoji_id === 2) {
        emoji_id_name = 'emoji_dull';
    } else if (emoji_id === 3) {
        emoji_id_name = 'emoji_scary';
    } else if (emoji_id === 4) {
        emoji_id_name = 'emoji_sad';
    } else if (emoji_id === 5) {
        emoji_id_name = 'emoji_fun';
    }

    $.ajax({
        type: "POST",
        url: "/add_del_emoji",
        data: {
            'film_id': film_id,
            'emoji_id': emoji_id,
            'count': count,
        },
        success: function (response) {
            $('#' + emoji_id_name).replaceWith(response);
        }
    });
}

function rateFilm(e, film_id, rating) {
    $.ajax({
        type: "POST",
        url: "/rate_film",
        data: {
            'film_id': film_id,
            'rating': rating,
        },
        success: function (response) {
            $('#rating_numbers').replaceWith(response);
        }
    });
}

function addDelTag(film_id, tag_id, count, name) {
    $.ajax({
        type: "POST",
        url: "/add_del_tag",
        data: {
            'film_id': film_id,
            'tag_id': tag_id,
            'count': count,
            'name': name,
        },
        success: function (response) {
            $('#tag_' + tag_id).replaceWith(response);
        }
    });
}
