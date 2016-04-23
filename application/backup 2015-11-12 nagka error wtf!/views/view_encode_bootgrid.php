     $(function()
{
function init()
{
$("#grid-data").bootgrid({
formatters: {
"link": function(column, row)
{
return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
}
},
rowCount: [-1, 10, 50, 75]
});
}
init();
$("#append").on("click", function ()
{
$("#grid-data").bootgrid("append", [{
id: 0,
sender: "hh@derhase.de",
received: "Gestern",
link: ""
},
{
id: 12,
sender: "er@fsdfs.de",
received: "Heute",
link: ""
}]);
});
$("#clear").on("click", function ()
{
$("#grid-data").bootgrid("clear");
});
$("#removeSelected").on("click", function ()
{
$("#grid-data").bootgrid("remove");
});
$("#destroy").on("click", function ()
{
$("#grid-data").bootgrid("destroy");
});
$("#init").on("click", init);
$("#clearSearch").on("click", function ()
{
$("#grid-data").bootgrid("search");
});
$("#clearSort").on("click", function ()
{
$("#grid").bootgrid("sort");
});
$("#getCurrentPage").on("click", function ()
{
alert($("#grid").bootgrid("getCurrentPage"));
});
$("#getRowCount").on("click", function ()
{
alert($("#grid").bootgrid("getRowCount"));
});
$("#getTotalPageCount").on("click", function ()
{
alert($("#grid").bootgrid("getTotalPageCount"));
});
$("#getTotalRowCount").on("click", function ()
{
alert($("#grid").bootgrid("getTotalRowCount"));
});
$("#getSearchPhrase").on("click", function ()
{
alert($("#grid").bootgrid("getSearchPhrase"));
});
$("#getSortDictionary").on("click", function ()
{
alert($("#grid").bootgrid("getSortDictionary"));
});
$("#grid-data").on("click", function ()
{
alert($("#grid-data").bootgrid("getSelectedRows"));
});
});