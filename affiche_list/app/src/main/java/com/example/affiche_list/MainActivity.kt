package com.example.affiche_list

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.view.View
import android.widget.Button
import android.widget.EditText

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)



        var button :  Button = findViewById(R.id.button)
        var editTextTextnom : EditText = findViewById(R.id.editTextTextnom)
        var editTextTextEmailAddress2 :EditText = findViewById(R.id.editTextTextEmailAddress2)

        button.setOnClickListener(View.OnClickListener {
            var nom = editTextTextnom.text.toString()
            var email = editTextTextEmailAddress2.text.toString()

            var intent = Intent(this@MainActivity, Mainaffiche::class.java)
            intent.putExtra("NOM", nom)
            intent.putExtra("EMAIL", email)
            startActivity(intent)
        })
    }
}