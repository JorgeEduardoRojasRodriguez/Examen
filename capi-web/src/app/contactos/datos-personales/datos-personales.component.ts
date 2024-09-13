import { Component, Input } from '@angular/core';
import { FloatLabelModule } from 'primeng/floatlabel';
import { Contacto } from '../../../domain/contactos.model';
import { FormsModule } from '@angular/forms';
import { InputTextModule } from 'primeng/inputtext';
import { CalendarModule } from 'primeng/calendar';

@Component({
  selector: 'app-datos-personales',
  standalone: true,
  imports: [FloatLabelModule, FormsModule, InputTextModule, CalendarModule],
  templateUrl: './datos-personales.component.html',
  styleUrl: './datos-personales.component.css',
})
export class AppDatosPersonalesComponent {
  title = 'Datos Personales';
  @Input() contacto: Contacto = {};
  @Input() view = false;
  constructor() {}
}
