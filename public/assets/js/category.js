// カテゴリー一覧画面用のスクリプト

// 新規追加ボタンクリック時
document.addEventListener('DOMContentLoaded', function() {
    const showBtn = document.getElementById('show_new_category_btn');
    if (showBtn) {
        showBtn.addEventListener('click', function() {
            showNewCategoryForm();
        });
    }
});

// フォーム表示
function showNewCategoryForm() {
    document.getElementById('show_new_category_btn').style.display = 'none';
    document.getElementById('new_category_wrapper').style.display = 'block';
}

// フォーム非表示
function hideNewCategoryForm() {
    document.getElementById('show_new_category_btn').style.display = 'block';
    document.getElementById('new_category_wrapper').style.display = 'none';
    document.getElementById('new_category_name').value = '';
    document.getElementById('new_category_template').value = '';
}

// カテゴリー追加（一覧画面専用）
window.submitCategory = function() {
    const name = document.getElementById('new_category_name').value.trim();
    const template = document.getElementById('new_category_template').value.trim();

    if (name === '') {
        alert('カテゴリー名を入力してください');
        return;
    }

    fetch('/OshiCal/public/index.php?route=category/create', {
        method: 'POST',
        body: new URLSearchParams({ name, template })
    })
    .then(res => res.text())
    .then(js => eval(js));
};

// カテゴリー追加後にカードを動的に追加
window.addCategory = function(id, name) {
    const container = document.querySelector('.category-container');
    if (container) {
        const card = document.createElement('div');
        card.className = 'category-card';
        card.innerHTML = `
            <h3>${name}</h3>
            <button type="button" onclick="location.href='/OshiCal/public/index.php?route=category/show&id=${id}'">詳細</button>
            <button type="button" onclick="location.href='/OshiCal/public/index.php?route=category/edit&id=${id}'">編集</button>
            <button type="button" onclick="if(confirm('本当に削除しますか？')) location.href='/OshiCal/public/index.php?route=category/destroy&id=${id}'">削除</button>
        `;
        container.appendChild(card);
        hideNewCategoryForm();
    }
};
