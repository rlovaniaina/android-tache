package com.example.affiche_list

import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.widget.TextView

class Mainaffiche : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_mainaffiche)

        var textView : TextView = findViewById(R.id.textView)

        val nom = intent.getStringExtra("NOM")
        var email = intent.getStringExtra("EMAIL")

        textView. text = "nom: $email\nEmail: $nom"

    }
}