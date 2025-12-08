document.addEventListener('DOMContentLoaded', function () {

    function initDynamicSelect(selectId, wrapperId, inputName, callbackName) {
        const selectEl = document.getElementById(selectId);
        const wrapperEl = document.getElementById(wrapperId);
        const inputEl = wrapperEl ? wrapperEl.querySelector(`input[name="${inputName}"]`) : null;

        if (!selectEl || !wrapperEl || !inputEl) return;

        selectEl.addEventListener('change', function () {
            if (this.value === 'new') {
                selectEl.style.display = "none";
                wrapperEl.style.display = "block";
                inputEl.focus();

                if (selectId === 'category_select') {
                    addCategoryUI();
                }
            }
        });

        window[callbackName] = function (id, name) {
            const option = document.createElement('option');
            option.value = id;
            option.textContent = name;
            option.selected = true;

            const newOption = selectEl.querySelector('option[value="new"]');

            selectEl.insertBefore(option, newOption);

            wrapperEl.style.display = "none";
            selectEl.style.display = "inline-block";

            if (selectId === 'category_select') {
                resetCategoryUI();
            }
        };
    }

    // 推し一覧画面用：ボタンクリックでフォーム表示
    const showOshiBtn = document.getElementById('show_new_oshi_btn');
    const oshiWrapper = document.getElementById('new_oshi_wrapper');
    if (showOshiBtn && oshiWrapper) {
        showOshiBtn.addEventListener('click', function() {
            showOshiBtn.style.display = 'none';
            oshiWrapper.style.display = 'block';
            oshiWrapper.querySelector('input').focus();
        });

        // 戻るボタン
        window.hideNewOshiForm = function() {
            oshiWrapper.style.display = 'none';
            showOshiBtn.style.display = 'inline-block';
            oshiWrapper.querySelector('input').value = '';
        };

        // 推しカード追加
        window.addOshi = function(id, name) {
            const container = document.querySelector('.oshi-container');
            if (container) {
                const card = document.createElement('div');
                card.className = 'oshi-card';
                card.innerHTML = `
                    <h3>
                        <a href="/OshiCal/public/index.php?route=oshi/show&id=${id}">
                            ${name}
                        </a>
                    </h3>

                    <div class="card-buttons">
                        <a href="/OshiCal/public/index.php?route=oshi/edit&id=${id}">編集</a>
                        <a href="/OshiCal/public/index.php?route=oshi/destroy&id=${id}" onclick="return confirm('本当に削除しますか？');">削除</a>
                    </div>
                `;
                container.appendChild(card);
                hideNewOshiForm();
            }
        };
    }

    // イベント登録画面用：セレクトボックスで推し追加
    const oshiSelect = document.getElementById('oshi_select');
    if (oshiSelect && oshiSelect.tagName === 'SELECT') {
        initDynamicSelect('oshi_select', 'new_oshi_wrapper', 'new_oshi_name', 'addOshi');
    }

    initDynamicSelect('category_select', 'new_category_wrapper', 'new_category_name', 'addCategory');

    window.submitOshi = function () {
        const name = document.querySelector('input[name="new_oshi_name"]').value.trim();
        if (name === '') {
            alert('推し名を入力してください');
            return;
        }

        fetch('/OshiCal/public/index.php?route=oshi/create', {
            method: 'POST',
            body: new URLSearchParams({ name })
        })
        .then(res => res.text())
        .then(js => eval(js));
    };

    window.submitCategory = function () {
        const name = document.getElementById('new_category_name').value.trim();
        const template = document.getElementById('memo_area').value.trim();

        if (name === '') {
            alert('カテゴリー名を入力してください');
            return;
        }

        fetch('/OshiCal/public/index.php?route=category/create', {
            method: 'POST',
            body: new URLSearchParams({ name, template })
        })
        .then(res => res.text())
        .then(js => { 
            eval(js);
            resetCategoryUI();
            document.getElementById('new_category_wrapper').style.display = 'none';
            document.getElementById('category_select').style.display = 'inline-block';
            document.getElementById('new_category_name').value = '';
            document.getElementById('memo_area').value = '';
        });
    };

    //推し・カテゴリー追加時、追加用のテキストフォームから推し・カテゴリー選択用のプルダウンに戻る
    window.cancelNewItem = function(selectId, wrapperId) {
        const selectEl = document.getElementById(selectId);
        const wrapperEl = document.getElementById(wrapperId);

        wrapperEl.style.display = "none";
        selectEl.style.display = "inline-block";
        selectEl.value = "";

        const input = wrapperEl.querySelector('input');
        if (input) input.value = '';
        const textarea = wrapperEl.querySelector('textarea');
        if (textarea) textarea.value = '';


        if (selectId === 'category_select') {
            resetCategoryUI();
        }
    };
    
    function addCategoryUI() {
        const oshi = document.getElementById('oshi_select').closest('div');
        const title = document.querySelector('input[name="title"]').closest('div');
        const date = document.querySelector('input[name="date"]').closest('div');
        const submit = document.querySelector('button[type="submit"]')?.closest('div');

        oshi.style.display = "none";
        title.style.display = "none";
        date.style.display = "none";
        submit.style.display = "none";

        // メモにテンプレ例を表示
        const memo = document.getElementById('memo_area');
        memo.placeholder = 
            "カテゴリーごとに使う入力項目をテンプレートとして保存できます。\n" +
            "例)\n会場：(内容はイベント登録・編集時に入力してください)\n開演時間：\n金額：\n詳細：";

        document.getElementById('category_buttons').style.display = "block";
    }


    /**
     * ▼ カテゴリー追加キャンセル時のUI復元
     */
    function resetCategoryUI() {
        const oshi = document.getElementById('oshi_select').closest('div');
        const title = document.querySelector('input[name="title"]').closest('div');
        const date = document.querySelector('input[name="date"]').closest('div');
        const submit = document.querySelector('button[type="submit"]')?.closest('div');

        oshi.style.display = "block";
        title.style.display = "block";
        date.style.display = "block";
        submit.style.display = "block";

        const memo = document.getElementById('memo_area');
        memo.placeholder = "";
        memo.value = "";

        document.getElementById('category_buttons').style.display = "none";
    }

    // カテゴリー選択時にテンプレート取得
    document.getElementById('category_select').addEventListener('change', function () {
        const id = this.value;

        // 「新規追加」ならテンプレートを消すだけ
        if (id === 'new') {
            document.getElementById('memo_area').value = '';
            return;
        }

        // 選択されたカテゴリーに紐づくテンプレート取得
        fetch(`/OshiCal/public/index.php?route=category/template&id=${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('memo_area').value = data.template || '';
            });
    });
});
