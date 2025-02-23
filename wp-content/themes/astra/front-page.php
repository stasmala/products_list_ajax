<?php get_header(); ?>

<div class="shop-container">
    <!-- Левый блок: категории -->
    <aside id="sidebar">
        <h2><?php _e( 'Категории', 'text_categories' ); ?></h2>
        <div id="categories"></div>
    </aside>

    <!-- Правый блок: товары -->
    <main id="content">
        <div id="product-controls">
            <select id="sort">
                <option value="date"><?php _e( 'По дате', 'text_date' ); ?></option>
                <option value="price"><?php _e( 'По цене', 'text_price' ); ?></option>
                <option value="title"><?php _e( 'По названию', 'text_title' ); ?></option>
            </select>
            <select id="sort-order">
                <option value="DESC"><?php _e( 'По убыванию', 'text_desc' ); ?></option>
                <option value="ASC"><?php _e( 'По возрастанию', 'text_asc' ); ?></option>
            </select>
            <input type="text" id="search" placeholder="<?php _e( 'Поиск...', 'text_search' ); ?>">
        </div>

        <div id="product-list"></div>

        <div id="loader" style="display: none; text-align: center; padding: 20px;">
            <p><?php _e( 'Загрузка...', 'text_loading' ); ?></p>
        </div>

<!--        <button id="scroll-top">-->
<!--            ↑-->
<!--        </button>-->
    </main>
</div>

<div id="cookie-consent" class="cookie-consent-popup">
    <div class="cookie-consent-content">
        <p>Мы используем куки для улучшения работы сайта. Нажимая "Принять", вы соглашаетесь на использование куки.</p>
        <button id="accept-cookies">Принять</button>
    </div>
</div>

<?php get_footer(); ?>