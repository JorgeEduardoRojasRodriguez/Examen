import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root',
})
export class EmailsService {
  private apiUrl = environment.url;

  constructor(private http: HttpClient) {}

  deleteEmails(id: number): Observable<any> {
    return this.http.delete(this.apiUrl + '/emails/' + id);
  }
}
