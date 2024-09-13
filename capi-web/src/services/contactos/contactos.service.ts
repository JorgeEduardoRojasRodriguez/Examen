import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root',
})
export class ContactosService {
  private apiUrl = environment.url;

  constructor(private http: HttpClient) {}

  getContactos(
    query: string = '',
    page: number = 0,
    limit: number = 10
  ): Observable<any> {
    return this.http.post(this.apiUrl + '/contactos/paginated', {
      search: query,
      page,
      limit,
    });
  }

  getContacto(id: number): Observable<any> {
    return this.http.get(this.apiUrl + '/contactos/' + id);
  }

  createContacto(contacto: any): Observable<any> {
    return this.http.post(this.apiUrl + '/contactos', contacto);
  }

  updateContacto(contacto: any): Observable<any> {
    return this.http.put(this.apiUrl + '/contactos/' + contacto.id, contacto);
  }

  deleteContacto(id: number): Observable<any> {
    return this.http.delete(this.apiUrl + '/contactos/' + id);
  }
}
