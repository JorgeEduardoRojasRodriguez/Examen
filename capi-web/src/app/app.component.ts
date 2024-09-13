import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { ContactosComponent } from './contactos/contactos.component';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, ContactosComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'capi-web';
}
