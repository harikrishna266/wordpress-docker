import { ComponentFixture, TestBed } from '@angular/core/testing';
import { ThreeDUiComponent } from './three-d-ui.component';

describe('ThreeDUiComponent', () => {
  let component: ThreeDUiComponent;
  let fixture: ComponentFixture<ThreeDUiComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ThreeDUiComponent],
    }).compileComponents();

    fixture = TestBed.createComponent(ThreeDUiComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
