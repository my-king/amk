(function($){
    $.Metro.currentLocale = 'en';

    if (METRO_LOCALE != undefined)  $.Metro.currentLocale = METRO_LOCALE; else $.Metro.currentLocale = 'en';
    //console.log(METRO_LOCALE, $.Metro.currentLocale);

    $.Metro.Locale = {
        'en': {
            months: [
                "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December",
                "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
            ],
            days: [
                "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday",
                "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"
            ],
            buttons: [
                "Today", "Clear", "Cancel", "Help", "Prior", "Next", "Finish"
            ]
        },
        'br': {
            months: [
                "Janeiro", "Fevereiro", "Mar�o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro",
                "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"
            ],
            days: [
                "Domingo", "Segunda", "Ter�a", "Quarta", "Quinta", "Sexta", "Sab�do",
                "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"
            ],
            buttons: [
                "Hoje", "Limpar", "Cancelar", "Ajuda", "Anterior", "Pr�ximo", "Fim"
            ]
        },
        'fr': {
            months: [
                "Janvier", "Février", "Mars", "Avril", "Peut", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre",
                "Jan", "Fév", "Mar", "Avr", "Peu", "Jun", "Jul", "Aoû", "Sep", "Oct", "Nov", "Déc"
            ],
            days: [
                "Sunday", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi",
                "Sn", "Ln", "Md", "Mc", "Ju", "Vn", "Sm"
            ],
            buttons: [
                "Aujourd", "Effacer", "Cancel", "Help", "Prior", "Next", "Finish"
            ]
        },
        'ua': {
            months: [
                "Січень", "Лютий", "Березень", "Квітень", "Травень", "Червень", "Липень", "Серпень", "Вересень", "Жовтень", "Листопад", "Грудень",
                "Січ", "Лют", "Бер", "Кві", "Тра", "Чер", "Лип", "Сер", "Вер", "Жов", "Лис", "Гру"
            ],
            days: [
                "Неділя", "Понеділок", "Вівторок", "Середа", "Четвер", "П’ятниця", "Субота",
                "Нд", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"
            ],
            buttons: [
                "Сьогодні", "Очистити", "Скасувати", "Допомога", "Назад", "Вперед", "Готово"
            ]
        },
        'ru': {
            months: [
                "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь",
                "Янв", "Фев", "Мар", "Апр", "Май", "Июн", "Июл", "Авг", "Сен", "Окт", "Ноя", "Дек"
            ],
            days: [
                "Воскресенье", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота",
                "Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"
            ],
            buttons: [
                "Сегодня", "Очистить", "Отменить", "Помощь", "Назад", "Вперед", "Готово"
            ]
        },
        /** By NoGrief (nogrief@gmail.com) */
        'zhCN': {
            months: [
                "一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月",
                "一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"
            ],
            days: [
                "星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六",
                "日", "一", "二", "三", "四", "五", "六"
            ],
            buttons: [
                "今日", "清除", "Cancel", "Help", "Prior", "Next", "Finish"
            ]
        },
        'it': {
            months: [
                'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre',
                'Gen',' Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'
            ],
            days: [
                'Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato', 'Domenica',
                'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab', 'Dom'
            ],
            buttons: [
                "Oggi", "Cancella", "Cancel", "Help", "Prior", "Next", "Finish"
            ]
        },
        'de': {
            months: [
                "Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember",
                "Jan", "Feb", "Mrz", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"
            ],
            days: [
                "Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag",
                "So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"
            ],
            buttons: [
                "Heute", "Zurücksetzen", "Abbrechen", "Hilfe", "Früher", "Später", "Fertig"
            ]
        },
        /** By Javier Rodríguez (javier.rodriguez at fjrodriguez.com) */
        'es': {
            months: [
                "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre",
                "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sept", "Oct", "Nov", "Dic"
            ],
            days: [
                "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado",
                "Do", "Lu", "Mar", "Mié", "Jue", "Vi", "Sáb"
            ],
            buttons: [
               "Hoy", "Limpiar", "Cancel", "Help", "Prior", "Next", "Finish"
            ]
        }
    };

    $.Metro.setLocale = function(locale, data){
        $.Metro.Locale[locale] = data;
    };
})(jQuery);
