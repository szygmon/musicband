/* API method to get paging information */
$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
  return {
    "iStart": oSettings._iDisplayStart,
    "iEnd": oSettings.fnDisplayEnd(),
    "iLength": oSettings._iDisplayLength,
    "iTotal": oSettings.fnRecordsTotal(),
    "iFilteredTotal": oSettings.fnRecordsDisplay(),
    "iPage": oSettings._iDisplayLength === -1 ?
      0 : Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
    "iTotalPages": oSettings._iDisplayLength === -1 ?
      0 : Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
  };
}

/* Style pagination control */
$.extend($.fn.dataTableExt.oPagination, {
  "repertoire": {
    "fnInit": function(oSettings, nPaging, fnDraw) {
      var oLang = oSettings.oLanguage.oPaginate;
      var fnClickHandler = function(e) {
        e.preventDefault();
        if (oSettings.oApi._fnPageChange(oSettings, e.data.action)) {
          fnDraw(oSettings);
        }
      };

      $(nPaging).append(
        '<ul class="pager pagenav">' +
        '<li class="first disabled"><a href="#">' + oLang.sFirst + '</a></li>' +
        '<li class="prev  disabled"><a href="#">' + oLang.sPrevious + '</a></li>' +
        '<li class="next  disabled"><a href="#" style="float: none !important;">' + oLang.sNext + '</a></li>' +
        '<li class="last  disabled"><a href="#">' + oLang.sLast + '</a></li>' +
        '</ul>'
      );
      var els = $('a', nPaging);
      $(els[0]).bind('click.DT', {
        action: "first"
      }, fnClickHandler);
      $(els[1]).bind('click.DT', {
        action: "previous"
      }, fnClickHandler);
      $(els[2]).bind('click.DT', {
        action: "next"
      }, fnClickHandler);
      $(els[3]).bind('click.DT', {
        action: "last"
      }, fnClickHandler);
    },

    "fnUpdate": function(oSettings, fnDraw) {
      var iListLength = 5;
      var oPaging = oSettings.oInstance.fnPagingInfo();
      var an = oSettings.aanFeatures.p;
      var i, j, sClass, iStart, iEnd, iHalf = Math.floor(iListLength / 2);

      if (oPaging.iTotalPages < iListLength) {
        iStart = 1;
        iEnd = oPaging.iTotalPages;
      } else if (oPaging.iPage <= iHalf) {
        iStart = 1;
        iEnd = iListLength;
      } else if (oPaging.iPage >= (oPaging.iTotalPages - iHalf)) {
        iStart = oPaging.iTotalPages - iListLength + 1;
        iEnd = oPaging.iTotalPages;
      } else {
        iStart = oPaging.iPage - iHalf + 1;
        iEnd = iStart + iListLength - 1;
      }

      for (i = 0, iLen = an.length; i < iLen; i++) {
        // Remove the middle elements
        $('li:gt(1)', an[i]).filter(':not(.next,.last)').remove();

        // Add the new list items and their event handlers
        for (j = iStart; j <= iEnd; j++) {
          var act = "";
          if (j == oPaging.iPage + 1) {
            act = 'class="active"';
          }
          $('<li ' + act + '<a href="/ref#sClass"></a>' + '<a href="#">' + j + '</a></li>')
            .insertBefore($('.next,.last', an[i])[0])
            .bind('click', function(e) {
              e.preventDefault();
              oSettings._iDisplayStart = (parseInt($('a', this).text(), 10) - 1) * oPaging.iLength;
              fnDraw(oSettings);
            });
        }

        // Add / remove disabled classes from the static elements
        if (oPaging.iPage === 0) {
          $('li:first', an[i]).addClass('disabled');
          $('li.prev').addClass('disabled');
        } else {
          $('li:first', an[i]).removeClass('disabled');
          $('li.prev').removeClass('disabled');
        }

        if (oPaging.iPage === oPaging.iTotalPages - 1 || oPaging.iTotalPages === 0) {
          $('li.next').addClass('disabled');
          $('li:last', an[i]).addClass('disabled');
        } else {
          $('li.next').removeClass('disabled');
          $('li:last', an[i]).removeClass('disabled');
        }
      }
    }
  }
});