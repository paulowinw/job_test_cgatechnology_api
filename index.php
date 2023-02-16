<!DOCTYPE html>
<html lang="en">
<head>
    <title>CGI Incident List</title>
    <meta charset="utf-8">
    <link href="styles/examples-offline.css" rel="stylesheet">
    <link href="styles/kendo.common.min.css" rel="stylesheet">
    <link href="styles/kendo.rtl.min.css" rel="stylesheet">
    <link href="styles/kendo.default.min.css" rel="stylesheet">
    <link href="styles/kendo.default.mobile.min.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/jszip.min.js"></script>
    <script src="js/kendo.all.min.js"></script>
    <script src="js/console.js"></script>
</head>
<body>
    <p class="offline-button">CGI Incident List</p>
<div id="list">
    <div id="listView"></div>

    <script type="text/x-kendo-tmpl" id="template">
        <div class="incident-view k-widget">
            <dl>
                <dt>Number</dt>
                <dd>#:number#</dd>
                <dt>Incent date</dt>
                <dd>#:incidentdate#</dd>
                <dt>Project</dt>
                <dd>#:project#</dd>
                <dt>Project reference</dt>
                <dd>#:projectReference#</dd>
                <dt>Type</dt>
                <dd>#:type#</dd>
            </dl>
            <div class="edit-buttons">
            </div>
        </div>
    </script>
</div>
<script>
    $(document).ready(function () {
        var dataSource = new kendo.data.DataSource({
                transport: {
                    read: {
                        url: "incidents-list.php",
                        dataType: "json"
                    },
                    parameterMap: function (options, operation) {
                        if (operation !== "read" && options.models) {
                            return { models: kendo.stringify(options.models) };
                        }
                    }
                },
                batch: true,
                pageSize: 4,
                schema: {
                    model: {
                        id: "number",
                        fields: {
                            number: { editable: false, nullable: true },
                            incidentdate: { type: "string" },
                            project: { type: "string" },
                            projectReference: { type: "string" },
                            type: { type: "string" }
                        }
                    }
                }
            });

        var listView = $("#listView").kendoListView({
            dataSource: dataSource,
            selectable: true,
            navigatable: true,
            pageable: true,
            template: kendo.template($("#template").html())
        }).data("kendoListView");
    });

    $(document.body).keydown(function (e) {
        if (e.altKey && e.keyCode == 87) {
            $("#listView").focus();
        }
    });

</script>
<style>
    .incident-view {
        float: left;
        width: 50%;
        height: 350px;
        box-sizing: border-box;
        border-top: 0;
        position: relative;
    }

        .incident-view:nth-child(even) {
            border-left-width: 0;
        }

        .incident-view dl {
            margin: 10px 10px 0;
            padding: 0;
            overflow: hidden;
        }

        .incident-view dt, dd {
            margin: 0;
            padding: 0;
            width: 100%;
            line-height: 24px;
            font-size: 18px;
        }

        .incident-view dt {
            font-size: 11px;
            height: 16px;
            line-height: 16px;
            text-transform: uppercase;
            opacity: 0.5;
        }

        .incident-view dd {
            height: 46px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .incident-view dd .k-widget {
            font-size: 14px;
        }

    #list .k-listview {
        border-width: 1px 0 0;
        padding: 0;
        overflow: hidden;
        min-height: 298px;
    }

    .edit-buttons {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: right;
        padding: 5px;
        background-color: rgba(0,0,0,0.1);
    }

    .k-pager-wrap {
        border-top: 0;
    }

    @media only screen and (max-width : 620px) {

        .incident-view {
            width: 100%;
        }

            .incident-view:nth-child(even) {
                border-left-width: 1px;
            }
    }
</style>

</body>
</html>