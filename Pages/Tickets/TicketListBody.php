<?php

foreach ($ticketsData as $value) {
    $statusStyle = "";
    switch ($value[4]) {
        case "Created":
            $statusStyle = "badge text-bg-secondary";
            break;
        case "InProgress":
            $statusStyle = "badge text-bg-primary";
            break;
        case "Resolved":
            $statusStyle = "badge text-bg-success";
            break;
        case "Cancelled":
            $statusStyle = "badge text-bg-warning";
            break;
    }

    $isThereNewMessage =  "";
    if ($users->HaveHelpDeskPermissions()) {
        $isThereNewMessage = $value[8] == 0 ? "<span class='badge text-bg-warning'>New message</span>" : "";
    } else {
        $isThereNewMessage = $value[7] == 0 ? "<span class='badge text-bg-warning'>New message</span>" : "";
    }
    echo '
        <tr onclick="redirectToPage(\'Ticket.php?Id=' . $value[0] . '\')">
    <td>' . $value[1] . '</td>
    <td class="text-center">' . $value[2] . '</td>
    <td>' . $value[3] . '</td>
    <td><span class="' . $statusStyle . '">' . $value[4] . '</td>
    <td>' . $value[5] . '</td>
    <td>' . $value[6] . '</td>
    <td>' . $isThereNewMessage . '</td>
    <td class="text-end pe-3">
        <div class="icon-container">
            <span><i class="icon-icon" data-feather="align-right"></i></span>
            <span class="badge bg-secondary icon-text">Details</span>
        </div>
    </td>
</tr>
        ';
}
