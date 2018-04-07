/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
                        $(document).ready(function () {
                                        $("#news-slider").owlCarousel({
                                            items: 2,
                                            itemsDesktop: [1199, 2],
                                            itemsDesktopSmall: [980, 2],
                                            itemsMobile: [700, 1],
                                            pagination: false,
                                            navigation: true,
                                            navigationText: ["", ""],
                                            autoPlay: true
                                        });
                                        $("a").tooltip(); // for tooltips

                                        // Colorbox Call
                                        $(document).ready(function () {
                                            $("[rel^='lightbox']").prettyPhoto();
                                        });

                                    });



                                    function submit_form() {
                                        // Check Fields
                                        var complete = true;
                                        var error_color = '#FFD9D9';
                                        var fields = ['first_name', 'last_name', 'email', 'number', 'question'];
                                        var row = '';
                                        var i;
                                        for (i = 0; i < fields.length; ++i) {
                                            console.log(fields.length);
                                            var field = fields[i];
                                            $('#' + field).css('backgroundColor', 'inherit');
                                            var value = $('#' + field).val();
                                            // Validate Field
                                            if (!value) {
                                                if (field != 'message') {
                                                    $('#' + field).css('backgroundColor', error_color);
                                                    var complete = false;
                                                }
                                            } else {
                                                // Sheet Data
                                                row += '"' + value + '",';
                                            }
                                        }

                                        // Submission
                                        if (complete) {
                                            // Clean Row
                                            row = row.slice(0, -1);
                                            // Config
                                            var gs_sid = '1sXK2Wp0f3B_hC3MQPm-RqXwU8aueOpnweL9Toq_-7xw'; // Enter your Google Sheet ID here
                                            var gs_clid = '914656398258-g6evcoag7ihcqqurkt1scne07gu9a5kf.apps.googleusercontent.com'; // Enter your API Client ID here
                                            var gs_clis = 'Aj06U52b1ZNtMPvSTKrzJkOS'; // Enter your API Client Secret here
                                            var gs_rtok = '1/3Xp20tET2ft7P3I3nQVHBaL204C9jAv9-pN12hytNdg'; // Enter your OAuth Refresh Token here
                                            var gs_atok = false;
                                            var gs_url = 'https://sheets.googleapis.com/v4/spreadsheets/' + gs_sid + '/values/A1:append?includeValuesInResponse=false&insertDataOption=INSERT_ROWS&responseDateTimeRenderOption=SERIAL_NUMBER&responseValueRenderOption=FORMATTED_VALUE&valueInputOption=USER_ENTERED';
                                            var gs_body = '{"majorDimension":"ROWS", "values":[[' + row + ']]}';
                                            // HTTP Request Token Refresh
                                            var xhr = new XMLHttpRequest();
                                            xhr.open('POST', 'https://www.googleapis.com/oauth2/v4/token?client_id=' + gs_clid + '&client_secret=' + gs_clis + '&refresh_token=' + gs_rtok + '&grant_type=refresh_token');
                                            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                            xhr.onload = function () {
                                                var response = JSON.parse(xhr.responseText);
                                                var gs_atok = response.access_token;
                                                // HTTP Request Append Data
                                                if (gs_atok) {
                                                    var xxhr = new XMLHttpRequest();
                                                    xxhr.open('POST', gs_url);

                                                    xxhr.setRequestHeader('Content-type', 'application/json');
                                                    xxhr.setRequestHeader('Authorization', 'OAuth ' + gs_atok);
                                                    xxhr.onload = function () {
                                                        if (xxhr.status == 200) {
                                                            // Success
                                                            $('#message').html('<p>Row Added to Sheet | <a href="http://snydergroupinc.com/tutorials/tutorial-google-sheets-api.php">Add Another &raquo;</a></p><p>Response:<br/>' + xxhr.responseText + '</p>');
                                                        } else {
                                                            // Fail
                                                            $('#message').html('<p>Row Not Added</p><p>Response:<br/>' + xxhr.responseText + '</p>');
                                                        }
                                                    };
                                                    xxhr.send(gs_body);
                                                }
                                            };
                                            xhr.send();
                                        }
                                    }



