<?php

/**
 * Implements hook_default_rules_configuration().
 */
function commerce_stock_notifications_default_rules_configuration() {
  $rules['rules_send_commerce_stock_notifications'] = entity_import('rules_config', '{ "rules_send_commerce_stock_notifications" : {
    "LABEL" : "Send Commerce Stock Notifications",
    "PLUGIN" : "action set",
    "OWNER" : "rules",
    "REQUIRES" : ["rules"],
    "USES VARIABLES" : {
      "commerce_stock_notifications_product" : {
        "label" : "Product", "type" : "commerce_product" },
      "commerce_stock_notifications_email" : {
        "label" : "Email", "type" : "text" },
      "commerce_stock_notifications_path" : {
        "label" : "Path", "type" : "text" }
    },
    "ACTION SET" : [
      {
        "mail" : {
        "to" : ["commerce-stock-notify-email"],
          "subject" : "The product you were waiting for on [site:url-brief] is now back in stock!",
          "message" : "You asked to be notified when \u003Ca href=\u0022[commerce-stock-notify-path:value]\u0022\u003E[commerce-stock-notify-product:title-field]\u003C\/a\u003E was back in stock.",
          "from" : ["site:mail"],
          "language" : [""]
        }
      }
    ]
  }
  }');

  return $rules;
}
